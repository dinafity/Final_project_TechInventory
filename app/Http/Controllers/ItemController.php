<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|min:3',
            'stok'        => 'required|numeric|min:1',
            'harga'       => 'required|numeric',
        ]);

        $item = Item::create($request->only('nama_barang', 'stok', 'harga'));

        return response()->json([
            'success' => true,
            'message' => 'Item successfully added!',
            'data'    => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|min:3',
            'stok'        => 'required|numeric|min:1',
            'harga'       => 'required|numeric',
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->only('nama_barang', 'stok', 'harga'));

        return response()->json([
            'success' => true,
            'message' => 'Item successfully updated!',
            'data'    => $item
        ]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item successfully deleted!'
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');
        $items = Item::where('nama_barang', 'like', "%{$keyword}%")->get();

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function indexUser()
    {
        $items = Item::all();
        return view('items.user_index', compact('items'));
    }

    public function transaction(Request $request)
    {
        $item = Item::find($request->item_id);
        $jumlahBeli = $request->jumlah;

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction failed, item not found!'
            ]);
        }

        if ($item->stok < $jumlahBeli) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction failed, insufficient stock of goods!'
            ]);
        }

        $item->stok = $item->stok - $jumlahBeli;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaction Successful! Stock has been reduced successfully.',
            'data' => [
                'id'    => $item->id,
                'stok'  => $item->stok,
                'harga' => $item->harga,
                'total_value' => $item->harga * $item->stok
            ]
        ]);
    }

    public function getPublicApi()
    {
        $response = Http::get('https://dummyjson.com/quotes/random');
        
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'quote'   => $response->json()['quote'],  
                'author'  => $response->json()['author']
            ]);
        }

        return response()->json([
            'success' => false,
            'quote'   => 'Keep up the great spirit in managing the inventory for a brighter business future.',
            'author'  => 'Admin System'
        ]);
    }
}