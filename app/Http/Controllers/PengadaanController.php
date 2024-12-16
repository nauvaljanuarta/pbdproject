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

    public function store(Request $request)
    {
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

            $pengadaanId = DB::selectOne('CALL sp_create_pengadaan(?, ?, ?, ?, ?, ?, @p_idpengadaan)', [
                $iduser,
                $idVendor,
                'P', // status A(diterima), C(batal), P(proses)
                $subtotal, // Subtotal value
                $ppn, // PPN value
                $total, // Total value
            ]);

            // Ambil ID pengadaan dari variabel output
            $pengadaanId = DB::selectOne('SELECT @p_idpengadaan AS idpengadaan')->idpengadaan;

            // Simpan detail pengadaan
            foreach ($details as $barang) {
                DB::statement('CALL sp_create_detail_pengadaan(?, ?, ?, ?, ?)', [$pengadaanId, $barang['idbarang'], $barang['harga_satuan'], $barang['jumlah'], $barang['sub_total']]);
            }
            // Commit transaksi
            DB::commit();

            // Kembalikan respon sukses
            return redirect()->back()->with('success', 'Tambah pengadaan berhasil dilakukan');
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
        $pengadaan = Pengadaan::with(['details', 'vendor', 'user'])->findOrFail($id);
        $details = DetailPengadaan::where('idpengadaan', $id)->get();

        return view('pengadaan.detail', compact('pengadaan', 'details'));
    }

    public function edit($id)
    {
        $pengadaan = DB::table('pengadaan')->where('idpengadaan', $id)->first();
        $vendors = vendor::all();
        $barangs = Barang::all();
        $details = DB::table('detail_pengadaan')->join('barang', 'detail_pengadaan.idbarang', '=', 'barang.idbarang')->where('detail_pengadaan.idpengadaan', $id)->select('detail_pengadaan.*', 'barang.nama AS nama_barang')->get();

        if (!$pengadaan) {
            return redirect()->back()->withErrors('Pengadaan tidak ditemukan.');
        }

        return view('pengadaan.edit', compact('pengadaan', 'vendors', 'details', 'barangs'));
    }

    public function update(Request $request, $id)
{
    $vendorId = $request->input('id_vendor');
    $subtotal = $request->input('subtotal');
    $details = $request->input('details');

    try {
        $statusPengadaan = DB::table('pengadaan')->where('idpengadaan', $id)->value('status');

        if ($statusPengadaan == 'A') {
            return redirect()->back()->with('error', 'Pengadaan sudah diterima, tidak bisa diproses lagi.');
        }

        // Hitung PPN dan total nilai
        $ppn = DB::selectOne('SELECT pengadaan_PPN(?) AS ppn', [$subtotal])->ppn;
        $total = $subtotal + $ppn;

        // Menghapus detail pengadaan lama terlebih dahulu
        DB::statement('DELETE FROM detail_pengadaan WHERE idpengadaan = ?', [$id]);

        // Memanggil prosedur untuk memperbarui pengadaan
        DB::selectOne('CALL sp_edit_pengadaan(?, ?, ?, ?, ?, ?)', [
            $id,
            $vendorId,
            'P ',
            $subtotal,
            $ppn,
            $total
        ]);

        // Menambahkan detail baru
        foreach ($details as $barang) {
            DB::statement('CALL sp_create_detail_pengadaan(?, ?, ?, ?, ?)', [
                $id,
                $barang['idbarang'],
                $barang['harga_satuan'],
                $barang['jumlah'],
                $barang['sub_total']
            ]);
        }

        return redirect()->back()->with('success', 'Pengadaan berhasil diperbarui.');
    } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->with('error', 'Gagal memperbarui pengadaan: ' . $e->getMessage());
    }
}


    public function destroy($id)
    {
        try {
            $statusPengadaan = DB::table('pengadaan')->where('idpengadaan', $id)->value('status');

        if ($statusPengadaan == 'A') {
            return redirect()->back()->with('error', 'Pengadaan sudah diterima, tidak bisa diproses lagi.');
        }
            // Memanggil prosedur sp_delete_pengadaan untuk menghapus pengadaan
            DB::selectOne('CALL sp_delete_pengadaan(?)', [$id]);

            return redirect()->back()->with('success', 'Pengadaan berhasil dihapus.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal menghapus pengadaan: ' . $e->getMessage());
        }
    }
}
