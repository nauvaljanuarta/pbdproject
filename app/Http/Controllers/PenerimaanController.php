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
            $statusPengadaan = DB::table('pengadaan')->where('idpengadaan', $id_pengadaan)->value('status');

        if ($statusPengadaan == 'A') {
            return redirect()->back()->with('error', 'Pengadaan sudah diterima, tidak bisa diproses lagi.');
        }
            DB::beginTransaction();

            $iduser = Auth::id();

            DB::statement('CALL sp_create_penerimaan(?, ?)', [
                $id_pengadaan,
                $iduser,
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
    public function show($id)
{
    // Mengambil data penerimaan berdasarkan ID
    $penerimaan = DB::table('view_penerimaan')
        ->where('idpenerimaan', $id)
        ->first();

    // Mengambil detail penerimaan barang
    $detailPenerimaan = DB::table('view_detail_penerimaan')
        ->where('idpenerimaan', $id)
        ->get();

    return view('penerimaan.detail', compact('penerimaan', 'detailPenerimaan'));
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
