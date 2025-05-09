<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Menu;

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
        if ($validator->fails()) {
            //lempar pesan api
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Ambil data menu
        $menu = Menu::findOrFail($request->product_id);

        // Cek stok cukup atau tidak
        if ($menu->stock < $request->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        // Kurangi stok
        $menu->stock -= $request->quantity;
        $menu->save();


        //3 simpan ke table order
        $order = Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'user_id' => $request->user()->id,
            'status_pembayaran' => 'pending'
        ]);
        //4 lempar ke API
        return response()->json([
            'status' => 'success',
            'message' => 'Order Berhasil, stok dikurangi',
            'data' => $order
        ], 201);
    }
    public function konfirmasi(Request $request)
    {
        if (!$request->user()->tokenCan('admin')) {
            return response()->json(['message' => "maaf anda bukan admin"], 403);
        }
        //2. validasi request -> order id dan status pembayaran
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders_id',
            'status_pembayaran' => 'required|string|in:pending, lunas'
        ]);

        if ($validator->fails()) {
            //lempar pesan api
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf validasi gagal',
                'errors' => $validator->erorrs()
            ], 422);
        }
        
        $order = Order::findOrFail($request->order_id);
        $order->status_pembayaran = $request->status_pembayaran;
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status pembayaran berhasil diperbarui',
            'data' => $order
        ]);
    }
}
