<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaketRequest;
use Illuminate\Support\Str;
use App\Models\Paket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaketController extends Controller
{
    /*************************************************
     *                Return the View
     **************************************************/
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('templates.pages.paket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

    /*************************************************
     *                  Return the API
     **************************************************/

    public function list(){
        $get = Paket::with(['activation'])->orderBy('nama_paket', 'asc')->get();
        return response()->json([
            'result' => true,
            'message' => 'Success paket membership',
            'data' => $get
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['nama_paket']);
            Paket::create($data);

            DB::commit();

            return response()->json([
                'result' => true,
                'message' => 'Success insert new data paket membership',
                'data' => []
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
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
        try{
            $paket['activation'] = @$paket->activation;
            return response()->json([
                'result' => true,
                'message' => 'Success paket membership',
                'data' => $paket
            ], 200);
        }catch (NotFoundHttpException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketRequest $request, Paket $paket)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['nama_paket']);

            $paket->update($data);

            DB::commit();

            return response()->json([
                'result' => true,
                'message' => 'Success update new data paket membership',
                'data' => []
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
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
        DB::beginTransaction();
        try {
            $paket->delete();

            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success delete data paket membership',
                'data' => []
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 400);
        }
    }
}
