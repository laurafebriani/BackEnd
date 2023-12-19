<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if ($user){
            if(password_verify($request->password, $user->password)){
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 200,
                    'message' => 'Login Success',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ]); 
            }
            return $this->error("Password Salah");
        }
        return $this->error("Email Tidak Terdaftar");
    }

    public function register(Request $request){
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ];
        $messages = [
            'name.required' => 'Nama Lengkap Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email Tidak Valid',
            'email.unique' => 'Email Sudah Terdaftar',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password Minimal 6 Karakter',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => 401,
                'message' => $validator->errors()
            ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            // 'password' => Hash::make($request->password)
            //password menggunakan bcrypt
            'password' => bcrypt($request->password)
        ]);
        if($user){
            return response()->json([
                'status' => 200,
                'message' => 'Register Success',
                'data' => $user
            ]);
        }
        return $this->error('Register Failed');
    }

    public function error($pesan){
        return response()->json([
            'status' => 401,
            'message' => $pesan,
        ]);
    }
    // get all user
    public function getuser(){
        $user = User::all();
        if($user){
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Menampilkan Data User',
                'data' => $user
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Data User Tidak Ditemukan'
        ]);
    }
}