<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    // Menampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return response()->json([
            'status' => 'success',
            'data' => $menus
        ], 200);
    }

    // Menampilkan menu berdasarkan ID
    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $menu
        ], 200);
    }

    // Menambahkan menu baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $menu
        ], 201);
    }

    // Mengupdate menu berdasarkan ID
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $menu
        ], 200);
    }

    // Menghapus menu berdasarkan ID
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu not found'
            ], 404);
        }

        $menu->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu deleted successfully'
        ], 200);
    }
}
