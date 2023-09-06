<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsRequest;
use App\Models\IsMembership;
use App\Models\Paket;
use App\Models\TransactionMembership;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function list(Request $request){
        $get = TransactionMembership::with(['paket', 'users', 'membership']);

        // if(@$request->jenis_kelamin){
        //     $get->where('jenis_kelamin', $request->jenis_kelamin);
        // }

        // if(@$request->status){
        //     $get->where('status', $request->status);
        // }

        // if(@$request->paket){
        //     $paket = $request->paket;
        //     $get->whereHas('paket', function($query) use($paket){
        //         $query->where('slug', $paket);
        //     });
        // }

        return response()->json([
            'result' => true,
            'message' => 'Success user Transaction on Membership',
            'data' => $get->orderBy('created_at', 'desc')->get()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionsRequest $request)
    {
        DB::beginTransaction();
        try {
            $dateNow = Carbon::now();
            $data = $request->all();
            $data['membership_id'] = Auth::user()->is_member->member->id;
            $data['kode_transaksi'] = "{$dateNow->format('dm')}-{$dateNow->format('Y')}-{$dateNow->format('His')}-".mt_rand(100,999)."-".mt_rand(100,999)."-".(@$data['type'] == 1 ? "0{$data['type']}" : $data['type']);
            $data['tgl_transaksi'] = $dateNow->format('Y-m-d H:i:s');

            $data['expired_date'] = $dateNow->addDays(1)->format('Y-m-d H:i:s');

            $data['payment_url'] = $this->_generateUrlPayment($data['kode_transaksi'], $request->total_biaya, $request->paket_id);

            TransactionMembership::create($data);
            DB::commit();

            return response()->json([
                'result' => true,
                'message' => 'successful generate transaction',
                'data' => $data
            ], 201);
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json([
                'result' => false,
                'message' => $error->getMessage(),
                'data' => []
            ], 400);
        }

    }

    private function _generateUrlPayment($transCode, $total, $paket_id){
        // Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Set Item Order
        $paket = Paket::where('id', $paket_id)->first();
        $itemDetail = [
            'id' => $paket->id,
            'price' => (int)$paket->harga,
            'quantity' => 1,
            'name' => $paket->nama_paket
        ];

        $customer_details = array(
            'first_name'    => Auth::user()->is_member->member->nama_lengkap,
            'email'         => Auth::user()->is_member->member->email,
            'phone'         => Auth::user()->is_member->member->no_telp,
            'address'       => Auth::user()->is_member->member->alamat
        );

        $expiredTime = [
            'order_time' => Carbon::now()->format('Y-m-d H:i:s') . " +0700",
            'expiry_duration' => 24,
            'unit' => 'hour'
        ];

        // Buat array untuk dikirim ke midtrans
        $midtrans = array(
            'transaction_details' => array(
                'order_id' =>  $transCode,
                'gross_amount' => (int) $total,
            ),
            'customer_details' => $customer_details,
            'item_details' => [$itemDetail],
            'enabled_payments' => array('gopay','bank_transfer', 'shopeepay'),
            'custom_expiry' => $expiredTime,
            'vtweb' => array()
        );

        // return $midtrans;

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return $paymentUrl;
        }
        catch (Exception $e) {
            return [
                'result' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = TransactionMembership::where('kode_transaksi', $order_id)->firstOrFail();

        $callback = [
            'trans_callback' => $notification
        ];
        // Handle notification status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $callback['status'] = 'PENDING';
                }
                else {
                    $callback['status'] = 'SUCCESS';
                    $transaction->paid_status = '1';
                }
            }
        }
        else if ($status == 'settlement'){
            $callback['status'] = 'SUCCESS';
            $transaction->paid_status = '1';
        }
        else if($status == 'pending'){
            $callback['status'] = 'PENDING';
        }
        else if ($status == 'deny') {
            $callback['status'] = 'CANCELLED';
        }
        else if ($status == 'expire') {
            $callback['status'] = 'CANCELLED';
        }
        else if ($status == 'cancel') {
            $callback['status'] = 'CANCELLED';
        }

        $transaction->remark = $notification;
        // Simpan transaksi
        $transaction->save();

        // Kirimkan email
        if ($transaction)
        {
            if($status == 'capture' && $fraud == 'accept' )
            {
                //
            }
            else if ($status == 'settlement')
            {
                //
            }
            else if ($status == 'success')
            {
                //
            }
            else if($status == 'capture' && $fraud == 'challenge' )
            {
                return response()->json([

                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'

                ], 200);
            }
            else
            {
                return response()->json([

                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'

                ], 200);
            }

            return response()->json([

                    'code' => 200,
                    'message' => 'Midtrans Notification Success'

            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionMembership $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionMembership $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionMembership $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionMembership $transaction)
    {
        //
    }
}
