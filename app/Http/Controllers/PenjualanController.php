<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Margin;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $margins = Margin::all();
        $barangs = DB::select('
        SELECT barang.idbarang, barang.nama, MAX(stock.stock) as stock, MAX(barang.harga) as harga
        FROM barang
        JOIN stock ON barang.idbarang = stock.idbarang
        WHERE stock.stock > 0
        GROUP BY barang.idbarang, barang.nama
        ');
        $penjualans = Penjualan::all();
        return view ('penjualan.create', compact('margins','barangs', 'penjualans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil data dari request
        $idMarginPenjualan = $request->input('idmargin_penjualan');
        $subtotal = $request->input('subtotal');
        $details = $request->input('details'); // Pastikan ini berupa array

        try {
            // Mulai transaksi
            DB::beginTransaction();

            // Ambil margin penjualan
            $margin = DB::table('margin_penjualan')->where('idmargin_penjualan', $idMarginPenjualan)->first();
            $marginValue = $margin ? $margin->persen : 0;

            // Hitung PPN (11%)
            $ppn = ($subtotal * 11) / 100;

            // Hitung total (subtotal + margin + ppn)
            $marginAmount = ($subtotal * $marginValue) / 100;
            $total = $subtotal + $marginAmount + $ppn;

            // Ambil ID user
            $idUser = Auth::id();

            // Panggil stored procedure untuk membuat penjualan
            $penjualanId = DB::selectOne('CALL sp_create_penjualan(?, ?, ?, ?, ?, @p_idpenjualan)', [
                $idUser,
                $idMarginPenjualan,
                $subtotal,
                $total,
                $ppn
            ]);

            // Ambil ID penjualan dari variabel output
            $penjualanId = DB::selectOne('SELECT @p_idpenjualan AS idpenjualan')->idpenjualan;

            // Simpan detail penjualan
            foreach ($details as $barang) {
                DB::statement('CALL sp_create_detail_penjualan(?, ?, ?, ?, ?)', [
                    $penjualanId,
                    $barang['idbarang'],
                    $barang['harga_satuan'],
                    $barang['jumlah'],
                    $barang['sub_total']
                ]);
            }

            // Commit transaksi
            DB::commit();

            // Kembalikan respon sukses
            return redirect()->back()->with('success', 'Tambah penjualan berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'error',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
