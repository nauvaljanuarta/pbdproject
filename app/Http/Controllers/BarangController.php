<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // Menampilkan daftar barang
    public function index()
    {
        
        $barangs = Barang::all();
        $satuans = Satuan::all();
        return view('admin.barang', compact('barangs', 'satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idsatuan' => 'required|integer',
            'jenis' => 'required|string|max:1',
            'nama' => 'required|string|max:45',
            'status' => 'required|boolean',
            'harga' => 'required|integer',
        ]);

        DB::statement('CALL sp_create_barang(?, ?, ?, ?, ?)', [
            $request->idsatuan,
            $request->jenis,
            $request->nama,
            $request->status,
            $request->harga,
        ]);

        return redirect()->back()->with('success', 'Barang created successfully!');
    }

    // Fungsi untuk memperbarui data barang
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'idsatuan' => 'required|integer',
            'jenis' => 'required|string|max:1',
            'nama' => 'required|string|max:45',
            'status' => 'required|boolean',
            'harga' => 'required|integer',
        ]);

        // Memanggil stored procedure untuk memperbarui barang
        DB::statement('CALL sp_update_barang(?, ?, ?, ?, ?, ?)', [
            $id,
            $request->idsatuan,
            $request->jenis,
            $request->nama,
            $request->status,
            $request->harga,
        ]);

        // Redirect kembali ke halaman barang dengan pesan sukses
        return redirect()->back()->with('success', 'Barang updated successfully!');
    }

    // Fungsi untuk menghapus barang
    public function destroy($id)
    {
        // Memanggil stored procedure untuk menghapus barang
        DB::statement('CALL sp_delete_barang(?)', [$id]);

        // Redirect kembali ke halaman barang dengan pesan sukses
        return redirect()->back()->with('success', 'Barang deleted successfully!');
    }
}
