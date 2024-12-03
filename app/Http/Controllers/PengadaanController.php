<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\DetailPengadaan;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Barang;

class PengadaanController extends Controller
{
    // Menampilkan halaman pengadaan
    public function index()
    {
        $pengadaans = Pengadaan::with(['user', 'vendor', 'details.barang'])->get();
        return view('pengadaan.index', compact('pengadaans'));
    }

    // Menampilkan form tambah pengadaan
    public function create()
    {
        $users = User::all();
        $vendors = Vendor::where('status', 'A')->get(); // Hanya vendor aktif
        $barangs = Barang::where('status', 1)->get(); // Hanya barang aktif
        return view('pengadaan.create', compact('users', 'vendors', 'barangs'));
    }

    // Menyimpan pengadaan baru
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'user_iduser' => 'required|exists:users,iduser',
            'vendor_idvendor' => 'required|exists:vendors,idvendor',
            'status' => 'required|in:P,S,C',
            'subtotal_nilai' => 'required|numeric',
            'ppn' => 'required|numeric',
            'total_nilai' => 'required|numeric',
            'details.*.idbarang' => 'required|exists:barang,idbarang',
            'details.*.harga_satuan' => 'required|numeric',
            'details.*.jumlah' => 'required|numeric',
            'details.*.sub_total' => 'required|numeric',
        ]);

        // Mulai transaksi database
        try {
            DB::beginTransaction();

            // Simpan pengadaan
            $pengadaan = Pengadaan::create([
                'user_iduser' => $validatedData['user_iduser'],
                'vendor_idvendor' => $validatedData['vendor_idvendor'],
                'status' => $validatedData['status'],
                'subtotal_nilai' => $validatedData['subtotal_nilai'],
                'ppn' => $validatedData['ppn'],
                'total_nilai' => $validatedData['total_nilai'],
            ]);

            // Simpan detail pengadaan
            foreach ($validatedData['details'] as $detail) {
                DetailPengadaan::create([
                    'idpengadaan' => $pengadaan->idpengadaan,
                    'idbarang' => $detail['idbarang'],
                    'harga_satuan' => $detail['harga_satuan'],
                    'jumlah' => $detail['jumlah'],
                    'sub_total' => $detail['sub_total'],
                ]);
            }

            DB::commit();
            return redirect()->route('pengadaan.index')->with('success', 'Pengadaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    // Menampilkan detail pengadaan
    public function show($id)
    {
        $pengadaan = Pengadaan::with(['user', 'vendor', 'barang'])->findOrFail($id);
        return view('pengadaan.detail', compact('pengadaan'));
    }
}
