<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function list(Request $request){
        $get = Membership::with(['paket', 'transaksi']);

        if(@$request->jenis_kelamin){
            $get->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if(@$request->status){
            $get->where('status', $request->status);
        }

        if(@$request->paket){
            $paket = $request->paket;
            $get->whereHas('paket', function($query) use($paket){
                $query->where('slug', $paket);
            });
        }

        return response()->json([
            'result' => true,
            'message' => 'Success user membership',
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
