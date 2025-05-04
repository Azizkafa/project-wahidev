<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    // Menampilkan detail transaksi berdasarkan ID
    public function show($id)
    {
        $transaction = Transaction::with('transactionDetails')->find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ], 200);
    }

    // Membuat transaksi baru
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
            'order_number' => 'required|unique:transactions|string|max:255',
            'order_type' => 'required|string',
            'note' => 'nullable|string',
            'table_number' => 'nullable|integer',
            'customer_name' => 'required|string|max:255',
            'tax' => 'required|numeric',
            'total' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $transaction = Transaction::create([
            'order_number' => $request->order_number,
            'order_type' => $request->order_type,
            'note' => $request->note,
            'table_number' => $request->table_number,
            'customer_name' => $request->customer_name,
            'tax' => $request->tax,
            'total' => $request->total,
            'status' => 1
        ]);
        foreach ($request->transaction_details as $key => $value) {
            $parts = explode('###', $value);
            $details = [
                'menus_id'=>$parts[0],
                'note'=>$parts[1],
            ];
           $transaction->transactionDetails()->create($details);
        }
            DB::commit();
            return response()->json([
            'status' => 'success',
            'data' => $transaction,'transaction_details'=>$transaction->transactionDetails
        ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            // Mengembalikan error dengan pesan exception
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process transaction: ' . $th->getMessage()
            ], 500);
        }
    }

    // Mengupdate transaksi berdasarkan ID
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_number' => 'required|string|max:255|unique:transactions,order_number,' . $id,
            'order_date' => 'required|date',
            'order_type' => 'required|string',
            'note' => 'nullable|string',
            'table_number' => 'nullable|integer',
            'customer_name' => 'required|string|max:255',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric',
            'total' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $transaction->update([
            'order_number' => $request->order_number,
            'order_date' => $request->order_date,
            'order_type' => $request->order_type,
            'note' => $request->note,
            'table_number' => $request->table_number,
            'customer_name' => $request->customer_name,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total' => $request->total
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ], 200);
    }

    // Menghapus transaksi berdasarkan ID
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully'
        ], 200);
    }
}
