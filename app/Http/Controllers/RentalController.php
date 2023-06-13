<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\CartModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriModel::all();
        $barang = BarangModel::orderBy('updated_at', 'desc')->paginate(4);
        return view('rental.home')
            ->with('kategori', $kategori)
            ->with('barang', $barang);
    }
    
    public function getDataBarang()
    {
        $barang = BarangModel::with('kategori')->latest()->take(4)->get();
        $kategori = KategoriModel::all();
        return response()->json(['barang' => $barang, 'kategori' => $kategori]);
    }

    public function showCart()
    {
        $user = Auth::user();
        $cartItems = CartModel::with('barang')->where('user_id', $user->id)->get();
        
        return response()->json($cartItems);
    }

    public function addToCart(Request $request)
    {
        $barangId = $request->input('barang_id');
        $userId = Auth::id();

        // Periksa apakah barang sudah ada di cart
        $cartItem = CartModel::where('user_id', $userId)
            ->where('barang_id', $barangId)
            ->first();

        if ($cartItem) {
            // Jika barang sudah ada di cart, tambahkan jumlahnya
            $cartItem->jumlah += 1;
            $cartItem->save();
        } else {
            // Jika barang belum ada di cart, buat entry baru
            $cartItem = new CartModel();
            $cartItem->user_id = $userId;
            $cartItem->barang_id = $barangId;
            $cartItem->jumlah = 1;
            $cartItem->save();
        }

        return response()->json(['message' => 'Barang berhasil ditambahkan ke cart.']);
    }

    public function decCart(Request $request){
        $barangId = $request->input('barang_id');
        $userId = Auth::id();

        // Periksa apakah barang sudah ada di cart
        $cartItem = CartModel::where('user_id', $userId)
            ->where('barang_id', $barangId)
            ->first();

            // Jika barang sudah ada di cart, tambahkan jumlahnya
        $cartItem->jumlah -= 1;
        $cartItem->save();

        return response()->json(['message' => 'Barang berhasil ditambahkan ke cart.']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}