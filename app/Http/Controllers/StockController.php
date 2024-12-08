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
        $stocks=Stock::all();
        return view('stock.index',compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function penerimaanstock($idPenerimaan)
    {
        try {
            // Memanggil stored procedure untuk memasukkan stok
            DB::beginTransaction(); // Memulai transaksi

            // Memanggil stored procedure
            DB::select('CALL sp_insert_stok_penerimaan(?)', [$idPenerimaan]);

            DB::commit(); // Menyimpan transaksi jika tidak ada error

            return redirect('/admin/stock')->with('success', 'Stok berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack(); // Jika terjadi error, rollback transaksi
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui stok: ' . $e->getMessage());
        }
    }
    public function penjualanstock()
    {
        //
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
