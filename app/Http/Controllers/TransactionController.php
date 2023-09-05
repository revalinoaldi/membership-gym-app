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
        $dateNow = Carbon::now();
        $data = $request->all();
        $data['membership_id'] = Auth::user()->id;
        $data['kode_transaksi'] = "{$dateNow->format('dm')}-{$dateNow->format('Y')}-{$dateNow->format('His')}-".mt_rand(100,999)."-".mt_rand(100,999)."-".(@$data['type'] == 1 ? "0{$data['type']}" : $data['type']);
        $data['tgl_transaksi'] = $dateNow->format('Y-m-d H:i:s');

        $data['expired_date'] = $dateNow->addDays(1)->format('Y-m-d H:i:s');

        $data['payment_url'] = $this->_generateUrlPayment($data['kode_transaksi'], $request->total_biaya, $request->paket_id);
        // $data['member'] = Auth::user()->is_member->member;

        return response()->json([
            'result' => true,
            'message' => 'successful generate transaction',
            'data' => $data
        ], 201);
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
            $paymentUrl = Snap::createTransaction($midtrans);

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
