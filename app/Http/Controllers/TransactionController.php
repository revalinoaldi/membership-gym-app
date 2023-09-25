<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsRequest;
use App\Models\IsMembership;
use App\Models\Membership;
use App\Models\Paket;
use App\Models\TransactionMembership;
use App\Models\TypeActivation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Transaction as TransactionMidtrans;


class TransactionController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {

        try {
            $transaksi = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->get(url('api/membership/transaction'))->throw()->json();

            return view('templates.pages.transaksi.index',[
                'transaksi' => $transaksi['data']['list'],
                'member' => $transaksi['data']['totalMember'],
                'invoice' => $transaksi['data']['totalTrans'],
                'paid' => $transaksi['data']['totalPaid'],
                'unpaid' => $transaksi['data']['totalUnPaid'],
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create(Request $request)
    {
        $paket = Http::withHeaders([
            'Authorization' => 'Bearer '.Session::get('token'),
            'Content-Type' => 'application/json'
        ])->get(url('api/paket/list'))->throw()->json();

        return view('templates.pages.transaksi.form',[
            'pakets' => $paket['data'],
            'isExtends' => 99
        ]);
    }

    /**
    * Display the specified resource.
    */
    // public function show(TransactionMembership $transaction)
    public function show($transaction)
    {
        try {
            $transaksi = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->get(url('api/membership/checkout/'.$transaction))->throw()->json();

            return view('templates.pages.transaksi.show',[
                'transaksi' => $transaksi['data']
            ]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function print($transaction)
    {
        try {
            $transaksi = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->get(url('api/membership/checkout/'.$transaction))->throw()->json();

            return view('templates.pages.transaksi.print',[
                'transaksi' => $transaksi['data']
            ]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function payment(TransactionMembership $transaction)
    {
        if($transaction->membership->kode_member != Auth::user()->is_member->member->kode_member){
            return redirect()->back();
        }

        try {
            if ($transaction->paid_status == 1) {
                throw new Exception("Transaksi sudah berhasil di bayarkan");
            }

            return view('templates.pages.transaksi.payment',[
                'transaksi' => $transaction,
                // 'status' => $statusTransaction['data']
            ]);
        } catch (Exception $e) {
            return redirect()->route('user.profile')->withErrors($e->getMessage());
        }
    }

    public function checkout(Request $request){
        try {
            $valid = Validator::make($request->all(), [
                'paket_id' => 'required|exists:pakets,id',
                'total_biaya' => 'required',
                'type' => 'required'
            ]);

            if($valid->fails()){
                return redirect()->back()->withErrors($valid->errors());
            }

            $paket = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->post(url('api/membership/checkout'), $request->all())->throw()->json();

            if(!$paket['result']){
                throw new Exception("Something when wrong, please try again.");
            }

            return redirect()->route('transaksi.payment.member', $paket['data']['kode_transaksi'])->with('success', 'Success Create Data');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }

    public function setCallback(Request $request){
        // dd($request);
        try {
            $statusTransaction = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->get(url('api/membership/transaction/status?kode_trans='.$request->order_id))->throw()->json();

            if(!$statusTransaction['result']){
                throw new Exception("Something when wrong, please try again.");
            }

            if($statusTransaction['data']['transaction_status'] == 'settlement' || $statusTransaction['data']['transaction_status'] == 'capture'){
                $this->_setCallback($statusTransaction['transaction']);

                return redirect()->route('user.profile')->with('success', 'Success paid member');
            }else{
                throw new Exception("Transaction is not Settlement.");
            }
        } catch (Exception $error) {
            return redirect()->route('user.profile')->withErrors($error->getMessage());
        }
    }

    private function _setCallback($notification){
        $status = $notification['transaction_status'];
        $type = $notification['payment_type'];
        $fraud = $notification['fraud_status'];
        $order_id = $notification['order_id'];

        // Cari transaksi berdasarkan ID
        $transaction = TransactionMembership::where('kode_transaksi', $order_id)->firstOrFail();
        $membership = Membership::where('id', $transaction->membership_id)->firstOrFail();

        $callback = [
            'trans_callback' => json_encode($notification)
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
            $membership->paket_id = $transaction->paket_id;
            $membership->status = 'ACTIVE';
            $membership->expired_date = Carbon::now()->add($transaction->paket->masa_aktif, $transaction->paket->activation->type)->format('Y-m-d H:i:s');
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
        $membership->save();

        return ['transaction' => $transaction, 'membership' => $membership];
    }

    public function checkStatus(Request $request){
        try {
            $trans = TransactionMembership::where('kode_transaksi', $request->kode_trans)->firstOrFail();

            // Set konfigurasi midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            $status = TransactionMidtrans::status($trans->kode_transaksi);

            return response()->json([
                'result' => true,
                'message' => "Success get transaction status",
                'data' => [
                    'transaction_status' => $status->transaction_status,
                    'transaction_id' => $status->transaction_id
                ],
                'transaction' => $status
            ]);
        } catch (Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(TransactionMembership $transaction)
    {
        //
    }

    public function list(Request $request){
        $get = TransactionMembership::with(['paket', 'paket.activation', 'users', 'membership']);

        if(Auth::user()->roles->pluck('name')[0] == "MEMBERSHIP"){
            $get->whereHas('membership', function($q){
                $q->where('id', Auth::user()->is_member->member->id);
            });
            $totalMember = Membership::where('id', Auth::user()->is_member->member->id)->count();
            $totalTrans = $get->count();
            $totalPaid = TransactionMembership::where('paid_status', '1')
                        ->whereHas('membership', function($q){
                            $q->where('id', Auth::user()->is_member->member->id);
                        })
                        ->sum('total_biaya');
            $totalUnPaid = TransactionMembership::where('paid_status', '0')
                        ->whereHas('membership', function($q){
                            $q->where('id', Auth::user()->is_member->member->id);
                        })
                        ->sum('total_biaya');
        }else{
            $totalMember = Membership::query()->count();
            $totalTrans = $get->count();
            $totalPaid = TransactionMembership::where('paid_status', '1')->sum('total_biaya');
            $totalUnPaid = TransactionMembership::where('paid_status', '0')->sum('total_biaya');
        }

        $dataTrans = $get->latest()->get();
        return response()->json([
            'result' => true,
            'message' => 'Success user Transaction on Membership',
            'data' => [
                'totalMember' => $totalMember,
                'totalTrans' => $totalTrans,
                'totalUnPaid' => $totalUnPaid,
                'totalPaid' => $totalPaid,
                'list' => $dataTrans
            ]
        ], 200);
    }

    public function listOne($transaction){
        $get = TransactionMembership::with(['paket', 'paket.activation', 'users', 'membership'])
                ->where('kode_transaksi', $transaction)
                ->orderBy('created_at', 'desc')->first();

        return response()->json([
            'result' => true,
            'message' => 'Success user Transaction on Membership',
            'data' => $get
        ], 200);
    }

    // ===============================================
    //                  NEXT ON API
    // ===============================================

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
        );

        // return $midtrans;

        try {
            // Ambil halaman payment midtrans
            // $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            $paymentUrl = Snap::getSnapToken($midtrans);


            // Redirect ke halaman midtrans
            return $paymentUrl;
        }
        catch (Exception $e) {
            return json_encode([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function cancleTransaction(Request $request, TransactionMembership $transaction){
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:transaction_memberships,kode_transaksi',
            'member_id' => 'required|exists:memberships,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error!',
                'error' => $validator->errors(),
                'result' => false
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Set konfigurasi midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            $callback = TransactionMidtrans::cancel($request->transaction_id);

            if($request->membership_id != Auth::user()->is_member->member->id){
                throw new Exception("Cannot cancel of the transaction! You not own this transaction!");
            }

            $callback['status'] = 'CANCELLED';

            $trans = TransactionMembership::where('kode_transaksi', $request->transaction_id)->firstOrFail();
            $trans->remark = $callback;
            $trans->save();

            DB::commit();

            return response()->json([
                'result' => true,
                'message' => 'Success, transaction is canceled',
                'data' => $trans
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
        $membership = Membership::where('id', $transaction->membership_id)->firstOrFail();

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
            $membership->paket_id = $transaction->paket_id;
            $membership->expired_date = Carbon::now()->add($transaction->paket->masa_aktif, $transaction->paket->activation->type)->format('Y-m-d H:i:s');
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
        $membership->save();

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
