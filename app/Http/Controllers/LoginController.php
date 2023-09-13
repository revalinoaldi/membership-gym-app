<?php

namespace App\Http\Controllers;

use App\Models\IsMembership;
use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function fetch(Request $request)
    {
        return response()->json([
            'result' => true,
            'message' => 'Data profile user berhasil diambil',
            'data' => $request->user(),
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'email|required',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'message' => 'Failed! Invalid Inputs',
                    'error' => $validator->errors(),
                    'result' => false
                ], 500);
            }

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized! Authentication Failed!',
                    'data' => []
                ], 500);
            }

            $user = User::where('email', $request->email)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'result' => true,
                'message' => 'Authenticated',
                'data' => [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => Auth::user()
                ]
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Authentication Failed! Something went wrong',
                'error' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $valid = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password]
            ];

            if($request->isMember == 1){
                $valid['jenis_kelamin'] = 'required';
                $valid['alamat'] = 'required';
                $valid['no_telp'] = 'required';
            }

            $validator = Validator::make($request->all(), $valid);
            if($validator->fails()){
                return response()->json([
                    'message' => 'Failed! Something went wrong',
                    'error' => $validator->errors(),
                    'result' => false
                ], 500);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized! Authentication Failed!',
                    'data' => []
                ], 500);
            }

            $user = User::where('email', $request->email)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            if($request->isMember == 1){
                $member = Membership::create([
                    'kode_member' => mt_rand(100000000, 999999999),
                    'nama_lengkap' => $request->name,
                    'email' => $request->email,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_telp' => $request->no_telp,
                    'token' => $tokenResult,
                    'tgl_daftar' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                IsMembership::create([
                    'user_id' => $user->id,
                    'membership_id' => $member->id
                ]);

                $user['isMember'] = $member;
            }

            DB::commit();

            return response()->json([
                'data' => [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user
                ],
                'message' => 'User Registered',
                'result' => true
            ], 201);
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json([
                'message' => 'Authentication Failed! Something went wrong',
                'error' => $error->getMessage(),
                'result' => false
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return response()->json([
            'data' => $token,
            'message' => 'Token Revoked',
            'result' => true
        ]);
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username
            ];

            if(@$request->password){
                $data['password'] = Hash::make($request->password);
            }

            $user = Auth::user();
            $user->update($data);

            if($request->isMember == 1){
                $member = Membership::where('kode_member', $user->is_member->member->kode_member)->update([
                    'nama_lengkap' => $request->name,
                    'email' => $request->email,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_telp' => $request->no_telp,
                ]);

                $user['isMember'] = $member;
            }

            DB::commit();
            return response()->json([
                'data' => $user,
                'message' => 'Profile Updated',
                'result' => true
            ]);
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json([
                'message' => 'Authentication Failed! Something went wrong',
                'error' => $error->getMessage(),
                'result' => false
            ], 500);
        }
    }
}
