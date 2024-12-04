<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaans=Penerimaan::all();
        return view('penerimaan.index',compact('penerimaans'));
    }
    public function store(Request $request, $id_pengadaan)
    {
        try {
            DB::beginTransaction();

            $iduser = Auth::id(); // ID user yang melakukan penerimaan (diambil dari sesi login)
            // Panggil Stored Procedure untuk menambahkan penerimaan dan detail_penerimaan
            DB::statement('CALL sp_create_penerimaan(?, ?)', [
                $id_pengadaan,  // ID Pengadaan
                $iduser,         // ID User Penerima
            ]);
            DB::commit();

            return redirect()->back()->with('success', 'Penerimaan berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penerimaan $penerimaan)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penerimaan $penerimaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penerimaan $penerimaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penerimaan $penerimaan)
    {
        //
    }
}
