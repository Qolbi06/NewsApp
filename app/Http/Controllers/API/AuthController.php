<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // cek credentials (login)
            $credentials = request(['email', 'password']);
            if (!Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            };

            // cek klo password g sesuai
            $user = User::where('email', $credentials['email'])->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            };

            // jika berasil cek password maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'bearer',
                'user' => $user
            ], 'Authenticated', 200);
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }
    
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);

            // cek kondisi password dan confirm password
            if ($request->password != $request->confirm_password) {
                return ResponseFormatter::error([
                    'message' => 'Password not match'
                ], 'Authentication Failed', 401);
            }

            // create akun
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // get data akun
            $user = User::where('email', $request->email)->first();

            // create token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Authenticated', 200);

        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something wnt wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request){
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success(
            [
                $token, 'Token Revoked', 200
        ]
        );
    }

    public function updatePassword(Request $request){
        try {
            //validate
            $this->validate($request, [
                'old_password' => 'required',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);
            
            $user = Auth::user();

            //cek password lama
            if(!Hash::check($request->old_password, $user->password)){
                return ResponseFormatter::error([
                    'message' => 'Password lama tidak sesuai',
                ], 'Authentication Failed', 401);
            }

            if($request->new_password != $request->confirm_password){
                return ResponseFormatter::error([
                    'message' => 'Password lama tidak sesuai',
                ], 'Authentication Failed', 401);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return ResponseFormatter::success([
                'message' => 'Password Berhasil Diubah',
            ], 'Authentication Failed', 200);
            
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something wnt wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function allUsers(){
        $user = User::where('role', 'user')->get();
        return ResponseFormatter::success(
            $user, 'Data user berhasil diambil');
    }

    public function updateProfile(Request $request){
        try {
            //validate
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'image' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]);

            //Get data user
            $user = Auth::user();

            if ($request->file('image') == '') {
                $user->profile->update([
                    'name' => $request->name,
                    'first_name' => $request->first_name
                ]);
            } else {
                Storage::disk('local')->delete('public/profile/' . basename($user->image));

                $image = $request->file('image');
                $image->storeAs('public/profile', $image->hashName());

                $user->profile->update([
                    'name' => $request->name,
                    'first_name' => $request->first_name,
                    'image' => $image->hashName()
                ]);
            }

            return ResponseFormatter::success([
                'profile' => $user->profile
            ], 'Profile Updated');
            

        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something Went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }
}