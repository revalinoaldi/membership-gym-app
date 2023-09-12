<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('templates.pages.users.index');
    }

    public function setLogin(Request $request){
        $valid = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if($valid->fails()){
            throw new Exception("Username or Password is incorrect, please try again.");
        }

        try {
            $user = Http::post(url('api/login'), [
                'email' => $request->email,
                'password' => $request->password
            ])->json();


            if(!$user['result']){
                throw new Exception("Username or Password is incorrect, please try again.");
            }

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials, $request->boolean('remember'))) {
                throw new Exception("Username or Password is incorrect, please try again.");
            }

            if ( ! Hash::check($request->password, $user['password'], [])) {
                throw new Exception('Invalid Credentials');
            }

            Session::put('token', $user['data']['access_token']);


            return redirect()->route('home')->with('success', 'Success login');

        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // return response()->json([
            //     'message' => 'Authentication Error!',
            //     'error' => $error->getMessage(),
            // ], 500);
        }
    }

    public function setLogout(Request $request){
        // Auth::logout();

        $user = Http::withHeaders([
            'Authorization' => 'Bearer '.Session::get('token'),
            'Content-Type' => 'application/json'
        ])->post(url('api/logout'), [])->json();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function setRegister(Request $request){
        $valid = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password],
            'isMember' => ['required']
        ];
        $valid['jenis_kelamin'] = 'required';
        $valid['alamat'] = 'required';
        $valid['no_telp'] = 'required';

        $validator = Validator::make($request->all(), $valid, [
            'email.unique' => 'Email already exist'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        try {
            $user = Http::post(url('api/register'), $request->all())->json();

            if(!$user['result']){
                throw new Exception($user['message']);
            }

            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials, true)) {
                throw new Exception("Username or Password is incorrect, please try again.");
            }

            if ( ! Hash::check($request->password, $user['password'], [])) {
                throw new Exception('Invalid Credentials');
            }

            Session::put('token', $user['data']['access_token']);

            return redirect()->route('home')->with('success', 'Success login');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}