<?php

namespace App\Http\Controllers;

use App\Mail\CheckIn;
use App\Models\KunjunganDayin;
use App\Models\KunjunganMember;
use App\Notifications\CheckInNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kunjungan = KunjunganMember::with('kunjungan')->where('member_id', Auth::user()->is_member->member->id)->get();
        $today = KunjunganMember::with('kunjungan')->where('member_id', Auth::user()->is_member->member->id)
                        ->whereHas('kunjungan', function($q){
                            $now = Carbon::now()->format('Y-m-d');
                            $q->where('datein', $now);
                        })->first();

        return view('templates.pages.kunjungan.index',[
            'checklist' => $kunjungan,
            'today' => $today
        ]);
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
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $valid = Validator::make($request->all(), [
                'kode_dayin' => 'required'
            ]);

            if($valid->fails()){
                return redirect()->back()->withErrors($valid->errors());
            }

            if(Auth::user()->is_member->member->status == "NON ACTIVE" || (Carbon::now()->startOfDay() > Carbon::parse(Auth::user()->is_member->member->expired_date)->startOfDay())){
                throw new Exception("User is Not Active! You can't do it checkin gym");
            }
            $dayin = KunjunganDayin::where('kode_kunjungan', $request->kode_dayin)
                    ->where('datein', Carbon::now()->format('Y-m-d'))->firstOrFail();

            $now = Carbon::now()->format('H:i:s');

            $kunjungan = KunjunganMember::create([
                'kunjungan_id' => $dayin->id,
                'transaction_code' => mt_rand(10000000,99999999),
                'member_id' => Auth::user()->is_member->member->id,
                'checkin_time' => $now,
                'user_id' => $dayin->user_id
            ]);

            $user = Auth::user();

            Notification::send($user, new CheckInNotification($kunjungan));
            Mail::to($dayin->users->email)->send(new CheckIn($kunjungan));

            DB::commit();
            return redirect()->route('kunjungan.index')->with('success', 'Success Checkin Today');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KunjunganMember $kunjungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KunjunganMember $kunjungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KunjunganMember $kunjungan)
    {
        DB::beginTransaction();
        try {
            $kunjungan->update([
                'checkout_time' => Carbon::now()->format('H:i:s'),
                'status_kunjungan' => '1'
            ]);

            DB::commit();
            return redirect()->route('kunjungan.index')->with('success', 'Success Checkout Today');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KunjunganMember $kunjungan)
    {
        //
    }
}
