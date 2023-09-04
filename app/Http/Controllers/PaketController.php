<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaketRequest;
use Illuminate\Support\Str;
use App\Models\Paket;
use Exception;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function list(){
        $get = Paket::with(['activation'])->orderBy('nama_paket', 'asc')->get();
        return response()->json([
            'result' => true,
            'message' => 'Success paket membership',
            'data' => $get
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
    public function store(PaketRequest $request)
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['nama_paket']);
            Paket::create($data);

            return response()->json([
                'result' => true,
                'message' => 'Success insert new data paket membership',
                'data' => []
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketRequest $request, Paket $paket)
    {
        dd($paket);
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['nama_paket']);

            $paket->update($data);

            return response()->json([
                'result' => true,
                'message' => 'Success update new data paket membership',
                'data' => []
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        try {
            $paket->delete();

            return response()->json([
                'result' => true,
                'message' => 'Success delete data paket membership',
                'data' => []
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }
}
