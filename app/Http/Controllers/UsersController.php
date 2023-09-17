<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUser;
use App\Models\KunjunganMember;
use App\Models\Membership;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('templates.pages.users.index',[
            'users' => User::whereHas('roles', function($q){
                return $q->whereIn('name', ['ADMINISTRATOR', 'KASIR']);
            })->latest()->get()
        ]);
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
            ])->throw()->json();


            if(!$user['result']){
                throw new Exception("Username or Password is incorrect, please try again.");
            }

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials, $request->boolean('remember'))) {
                throw new Exception("Username or Password is incorrect, please try again.");
            }

            Session::put('token', $user['data']['access_token']);

            if(empty(Session::get('token'))){
                throw new Exception("Something when wrong.");
            }
            return redirect()->route('home')->with('success', 'Success login');

        } catch (Exception $e) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect()->back()->withErrors($e->getMessage());
            // return response()->json([
            //     'message' => 'Authentication Error!',
            //     'error' => $error->getMessage(),
            // ], 500);
        }
    }

    public function setLogout(Request $request){
        Auth::guard('web')->logout();

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', new Password],
            'isMember' => ['required'],
            'paket_id' => ['required'],
            'total_biaya' => ['required']
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
            $user = Http::post(url('api/register'), $request->except(['paket_id', 'total_biaya']))->json();
            // dd($user);

            if(!$user['result']){
                throw new Exception($user['message']);
            }

            $credentials = $request->only('email', 'password');
            if (!Auth::guard('web')->attempt($credentials, true)) {
                throw new Exception("Username or Password is incorrect, please try again.");
            }

            $trans = Http::withHeaders([
                'Authorization' => 'Bearer '.$user['data']['access_token'],
                'Content-Type' => 'application/json'
            ])->post(url('api/membership/checkout'), [
                'paket_id' => $request->paket_id,
                'total_biaya' => $request->total_biaya,
                'type' => 1
            ])->throw()->json();

            Session::put('token', $user['data']['access_token']);
            if(empty(Session::get('token'))){
                throw new Exception("Something when wrong.");
            }

            return redirect()->route('home')->with('success', 'Success login');
        } catch (Exception $error) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect()->back()->withErrors($error->getMessage());
            // return response()->json($error->getMessage(), 400);
            // return redirect()->back()->withErrors($error->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.pages.users.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password]
        ];

        $valid = Validator::make($request->all(), $rule);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('ADMINISTRATOR');
            DB::commit();
            return redirect()->route('list.index')->with('success', 'Success added new Data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function profile()
    {
        try {
            $transaksi = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->get(url('api/membership/transaction'))->throw()->json();

            return view('templates.pages.users.profile',[
                'member' => Membership::with('paket')->find(Auth::user()->is_member->member->id),
                'transaksi' => $transaksi['data']['list'],
                'checklist' => KunjunganMember::where('member_id', Auth::user()->is_member->member->id)->get()
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

    }

    public function profileUpdate(Request $request){
        $valid = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->email.",email"],
            'isMember' => ['required'],
        ];

        if(@$request->password){
            $valid['password'] = ['required', 'string', new Password];
        }

        $valid['jenis_kelamin'] = 'required';
        $valid['alamat'] = 'required';
        $valid['no_telp'] = 'required';

        $validator = Validator::make($request->all(), $valid, [
            'email.unique' => 'Email already exist'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        // dd($request->all());

        try {
            $user = Http::withHeaders([
                'Authorization' => 'Bearer '.Session::get('token'),
                'Content-Type' => 'application/json'
            ])->post(url('api/profile/update'), $request->all())->throw()->json();
            // dd($user);

            if(!$user['result']){
                throw new Exception($user['message']);
            }

            return redirect()->route('user.profile')->with('success', 'Success update profile');
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $list)
    {
        return view('templates.pages.users.profile');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $list)
    {
        return view('templates.pages.users.form',[
            'user' => $list
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $list)
    {
        $rule = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->email.",email"]
        ];

        if($request->password){
            $rule['password'] = ['required', 'string', new Password];
        }

        $valid = Validator::make($request->all(), $rule);
        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }

        DB::beginTransaction();
        try {
            $dataUser = [
                'name' => $request->name,
                'email' => $request->email
            ];

            if($request->password){
                $dataUser['password'] = Hash::make($request->password);
            }

            $list->update($dataUser);
            DB::commit();
            return redirect()->route('list.index')->with('success', 'Success update new Data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $list)
    {
        //
    }
}
