<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::orderBy('idkartu_Stok', 'asc')->get();
        $currentStocks = DB::select("
        SELECT s.idbarang, b.nama AS nama_barang, MAX(s.stock) AS current_stock
        FROM stock s
        JOIN barang b ON s.idbarang = b.idbarang
        GROUP BY s.idbarang, b.nama
    ");
        return view('stock.index',compact('stocks', 'currentStocks'));
    }

    public function penerimaanStock($idPenerimaan)
{
    try {
        DB::beginTransaction();

        $detailPenerimaan = DB::select('SELECT * FROM detail_penerimaan WHERE idpenerimaan = ?', [$idPenerimaan]);

        foreach ($detailPenerimaan as $detail) {
            $stokBarang = DB::select('
                SELECT * FROM stock
                WHERE idbarang = ?
                ORDER BY idkartu_Stok DESC LIMIT 1',
                [$detail->barang_idbarang]
            );

            if ($stokBarang) {
                // barang baru
                DB::insert('
                    INSERT INTO stock (jenis_transaksi, masuk, keluar, stock, created_at, idtransaksi, idbarang)
                    VALUES (?, ?, ?, ?, ?, ?, ?)',
                    ['P', $detail->jumlah_terima, 0, $stokBarang[0]->stock + $detail->jumlah_terima, now(), $idPenerimaan, $detail->barang_idbarang]
                );
            } else {
                // barang lama
                DB::insert('
                    INSERT INTO stock (jenis_transaksi, masuk, keluar, stock, created_at, idtransaksi, idbarang)
                    VALUES (?, ?, ?, ?, ?, ?, ?)',
                    ['P', $detail->jumlah_terima, 0, $detail->jumlah_terima, now(), $idPenerimaan, $detail->barang_idbarang]
                );
            }
        }
        DB::update('UPDATE penerimaan SET status = ? WHERE idpenerimaan = ?', ['A', $idPenerimaan]);

        DB::commit();

        return redirect('/admin/stock')->with('success', 'Stok berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e);
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui stok: ' . $e->getMessage());
    }
}

    public function returstock()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
