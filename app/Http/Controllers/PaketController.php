<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaketRequest;
use Illuminate\Support\Str;
use App\Models\Paket;
use App\Models\TypeActivation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
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
        try {
            $paket = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->get(url('api/membership/paket/'))->throw()->json();

            // dd($paket);
            return view('templates.pages.paket.index',[
                'pakets' => $paket['data'],
                'aktivasi' => TypeActivation::get()
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

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
        try {
            return view('templates.pages.paket.form',[
                'paket' => $paket,
                'aktivasi' => TypeActivation::get()
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function submitCreate(Request $request){
        try {
            $paket = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->post(url('api/membership/paket'), $request->all())->throw()->json();

            if(!$paket['result']){
                throw new Exception("Something when wrong, please try again.");
            }

            return redirect()->back()->with('success', 'Success Create Data');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }

    public function submitUpdate(Request $request, $paket){
        try {
            $paketUpdate = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->post(url("api/membership/paket/{$paket}/update"), $request->all())->throw()->json();

            if(!$paketUpdate['result']){
                throw new Exception("Something when wrong, please try again.");
            }

            return redirect()->route('paket.index')->with('success', 'Success Updated Data');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }

    public function submitDelete(Request $request, $paket){
        try {
            $paketUpdate = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->delete(url("api/membership/paket/{$paket}"), [])->throw()->json();

            if(!$paketUpdate['result']){
                throw new Exception("Something when wrong, please try again.");
            }

            return redirect()->route('paket.index')->with('success', 'Success Updated Data');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }

    public function submitRestore(Request $request, $paket){
        try {
            $paketUpdate = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->post(url("api/membership/paket/{$paket}/restore"), $request->all())->throw()->json();

            if(!$paketUpdate['result']){
                throw new Exception("Something when wrong, please try again.");
            }

            return redirect()->route('paket.index')->with('success', 'Success Restore Data');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }

    /*************************************************
     *                  Return the API
     **************************************************/

    public function listForMember(){
        $get = Paket::with(['activation'])->orderBy('harga', 'asc')->orderBy('nama_paket', 'asc')->get();
        return response()->json([
            'result' => true,
            'message' => 'Success paket membership',
            'data' => $get
        ], 200);
    }

    public function list(){
        $get = Paket::withTrashed()->with(['activation'])->orderBy('harga', 'asc')->orderBy('nama_paket', 'asc')->get();
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

    public function restore(Request $request, $paket)
    {
        DB::beginTransaction();
        try {
            if (!$paket) {
                throw new Exception("Validation Error");
            }

            Paket::withTrashed()->where('slug', $paket)->restore();

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
