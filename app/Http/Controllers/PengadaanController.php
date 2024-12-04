<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $pengadaans = Pengadaan::with(['user', 'vendor', 'details'])->get();
        return view('pengadaan.index', compact('pengadaans'));
    }

    // Menampilkan form tambah pengadaan
    public function create()
    {
        $users = User::all();
        $vendors = Vendor::all(); // Hanya vendor aktif
        $barangs = Barang::all(); // Hanya barang aktif
        return view('pengadaan.create', compact('users', 'vendors', 'barangs'));
    }

    // Menyimpan pengadaan baru
    public function store(Request $request)
    {
        // Validasi input
        // dd($request);
        // Ambil data dari request
        $idVendor = $request->input('id_vendor');
        $subtotal = $request->input('subtotal');
        $details = $request->input('details'); // Pastikan ini berupa array

        try {
            // Mulai transaksi
            DB::beginTransaction();

            // Panggil fungsi MySQL untuk menghitung PPN
            $ppn = DB::selectOne('SELECT pengadaan_PPN(?) AS ppn', [$subtotal])->ppn;

            // Hitung total
            $total = $subtotal + $ppn;
            $iduser = Auth::id();
            // Simpan data pengadaan menggunakan prosedur
            $pengadaanId = DB::selectOne('CALL sp_create_pengadaan(?, ?, ?, ?, ?, ?, @p_idpengadaan)', [
                $iduser, // The ID of the logged-in user
                $idVendor, // The ID of the vendor
                'P', // Status (e.g., 'A' for active)
                $subtotal, // Subtotal value
                $ppn, // PPN value
                $total, // Total value
            ]);

            // Ambil ID pengadaan dari variabel output
            $pengadaanId = DB::selectOne('SELECT @p_idpengadaan AS idpengadaan')->idpengadaan;

            // Simpan detail pengadaan
            foreach ($details as $barang) {
                DB::statement('CALL sp_create_detail_pengadaan(?, ?, ?, ?, ?)', [
                    $pengadaanId,
                    $barang['idbarang'],
                    $barang['harga_satuan'],
                    $barang['jumlah'],
                    $barang['sub_total']
                ]);
            }

            // Commit transaksi
            DB::commit();

            // Kembalikan respon sukses
            return redirect()->back();
        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaksi
            DB::rollBack();
            dd($e);
            // Kembalikan respon error
            return response()->json(
                [
                    'message' => 'error',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }


    // Menampilkan detail pengadaan
    public function show($id)
    {
        $pengadaan = DetailPengadaan::with(['pengadaan', 'barang'])->findOrFail($id);
        return view('pengadaan.detail', compact('pengadaan'));
    }
}
