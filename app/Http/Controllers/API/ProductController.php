<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //ambil variable cari
        $cari = $request->query('cari');

        //ambil data product dari model
        $products = Product::where('nama', 'like', '%' . $cari . '%')->get();

        // lempar data ke API
        return response()->json($products);
    }
    public function show($id)
    {
        $products = Product::where('id', $id)->first();

        return response()->json($products);
    }
    public function store(Request $request)
    {
        //1. data dari frontend di validasi apakah sudah atau belum
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'harga' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        //2. kasih pesan ke frontend jika ada data yang tidak valid
        if ($validator->fails()) {
            //lempar data API
            return response()->json([
                'status' => 'error',
                'message' => 'maaf validasi gagal',
                'erorrs' => $validator->errors()
            ], 422);/* ketika front end mengirimkan data ke backend itu di tolak, misal ketika mengisi form register */
        }
        //simpan variable validated
        $dataProduct = $validator->validated();

        //upload gambar
        if ($request->hasFile('gambar')) {
            $dataProduct['gambar'] = $request->file('gambar')->store('produk', 'public');
        }
        //3. data disimpan ke database
        $product = Product::create($dataProduct);

        //4. kasih pesan ke frontend kalau berhasil simpan
        return response()->json([
            'status' => 'success',
            'message' => 'Product Berhasil Ditambahkan',
            'data' => $product
        ], 201);
    }
    public function destroy($id){
        //ambil 1 data products
        $product = Product::where('id', $id)->first();
        
        //kalau id nya tidak ada
        if(empty($product)){
            return response()->json(['message' => "Maaf id tidak ada"], 404);
        }
        //hapus
        $product->delete();


        //lempai api
        return response()->json(['message' => "product berhasil dihapus"]);
    }
}
