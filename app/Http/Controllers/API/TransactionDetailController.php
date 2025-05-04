<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionDetailController extends Controller
{
    // Menampilkan semua transaksi detail
    public function index()
    {
        $transactionDetails = TransactionDetail::all();
        return response()->json([
            'status' => 'success',
            'data' => $transactionDetails
        ], 200);
    }

    // Menampilkan detail transaksi berdasarkan ID
    public function show($id)
    {
        $transactionDetail = TransactionDetail::find($id);

        if (!$transactionDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction detail not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transactionDetail
        ], 200);
    }

    // Menambahkan detail transaksi baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'menus_id' => 'required|exists:menus,id',
            'note' => 'nullable|string',
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        // Simpan data transaksi detail baru
        $transactionDetail = TransactionDetail::create([
            'menus_id' => $request->menus_id,
            'note' => $request->note,
            'transaction_id' => $request->transaction_id,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $transactionDetail
        ], 201);
    }

    // Mengupdate transaksi detail berdasarkan ID
    public function update(Request $request, $id)
    {
        $transactionDetail = TransactionDetail::find($id);

        if (!$transactionDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction detail not found'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'menus_id' => 'required|exists:menus,id',
            'note' => 'nullable|string',
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        // Update data transaksi detail
        $transactionDetail->update([
            'menus_id' => $request->menus_id,
            'note' => $request->note,
            'transaction_id' => $request->transaction_id,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $transactionDetail
        ], 200);
    }

    // Menghapus transaksi detail berdasarkan ID
    public function destroy($id)
    {
        $transactionDetail = TransactionDetail::find($id);

        if (!$transactionDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction detail not found'
            ], 404);
        }

        // Hapus transaksi detail
        $transactionDetail->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction detail deleted successfully'
        ], 200);
    }
}
