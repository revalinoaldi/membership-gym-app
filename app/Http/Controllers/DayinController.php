<?php

namespace App\Http\Controllers;

use App\Models\KunjunganDayin;
use App\Models\KunjunganMember;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DayinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = KunjunganDayin::where('datein', Carbon::now()->format('Y-m-d'));
        return view('templates.pages.dayin.index',[
            'totalToday' => $today->first(),
            'allTotal' => KunjunganMember::count(),
            'dayins' => KunjunganDayin::orderBy('datein', 'desc')->get()
        ]);
    }

    public function show(KunjunganDayin $dayin){

        $kunjungan = KunjunganMember::with(['kunjungan', 'membership'])->whereHas('kunjungan', function($q) use($dayin){
            $q->where('kode_kunjungan', $dayin->kode_kunjungan);
        })->get();
        // dd($kunjungan->toArray());
        return view('templates.pages.dayin.listall', [
            'dayin' => $dayin,
            'checklist' => $kunjungan
        ]);
    }

    public function all(Request $request){

        $kunjungan = KunjunganMember::with(['kunjungan' => function($q){ $q->orderBy('datein', 'desc'); }, 'membership'])->get();
        // dd($kunjungan->toArray());
        return view('templates.pages.dayin.listall', [
            'checklist' => $kunjungan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function generateBulk(){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $a = 0;
            do {
                if($a > 0){
                    $tgl = Carbon::now()->addDays($a)->format('Y-m-d');
                }else{
                    $tgl = Carbon::now()->format('Y-m-d');
                }
                KunjunganDayin::where('datein', $tgl)->firstOr(function() use($tgl) {
                    $dayin = KunjunganDayin::create([
                        'kode_kunjungan' => mt_rand(100000,999999),
                        'datein' => $tgl,
                        'user_id' => Auth::user()->id
                    ]);

                    return $dayin;
                });
                $a++;
            } while ($a < (@$request->bulk != 0 ? $request->bulk : 1));

            DB::commit();
            return redirect()->route('dayin.index')->with('success', 'Success added Date Kunjungan Day In');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
