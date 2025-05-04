<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        //validasi apakah benar user isi nama, email, & password
        //1. data dari frontend di validasi apakah sudah atau belum
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',/* memberikan error email has been already taken */
            'password' => 'required|min:6',
        ]);


        //2. kasih pesan ke frontend jika ada data yang tidak valid
        if($validator->fails()) {
            //lempar pesan api
            return response()->json([
            'status' => 'error',
            'message' => 'Maaf Validasi gagal',
            'errors' => $validator->errors()
            ], 422);
        }
        //3. Simpan ke tabel user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // buat token
        $token = $user->createToken('auth_token', [$user->role])->plainTextToken;
        //4. Lempar ke API
        return response()->json([
            'message' => 'Register Berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',/* memberikan error email has been already taken */
            'password' => 'required|min:6',
        ]);


        //2. kasih pesan ke frontend jika ada data yang tidak valid
        if($validator->fails()) {
            //lempar pesan api
            return response()->json([
            'status' => 'error',
            'message' => 'Maaf Validasi gagal',
            'errors' => $validator->errors()
            ], 422);
        }
        //3. cek email terdaftar atau tidak
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json([
                'message' => "email anda tidak terdaftar"
            ], 404);
        }
        //4. cocokkan inputan user dengan password yang ada di database
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Password Anda Salah'
            ], 401);
        }
        // buat token
        $token = $user->createToken('auth_token', [$user->role])->plainTextToken;
        //4. Lempar ke API
        return response()->json([
            'message' => 'Login Berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }
}

