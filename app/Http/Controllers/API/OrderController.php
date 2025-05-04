<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        //1. validasi (product_id, quantity)
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
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

        //3 simpan ke table order
        $order = Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'user_id' => $request->user()->id
        ]);
        //4 lempar ke API
        return response()->json([
            'status' => 'success',
            'message' => 'Order Berhasil',
            'data' => $order
        ], 201);
        
    }
    public function konfirmasi(Request $request){
        if (!$request ->user()->tokenCan('admin')){
            return response()->json(['message' => "maaf anda bukan admin"], 403);
        }
    //2. validasi request -> order id dan status pembayaran
    $validator = Validator::make($request->all(), [
        'order_id' => 'required|integer',
        'status_pembayaran' => 'required|string'
    ]); 

    if($validator->fails()){
        //lempar pesan api
        return response()->json([
            'status' => 'error',
            'message' => 'Maaf validasi gagal',
            'errors' => $validator->erorrs()
        ], 422);
    }
    }
}
