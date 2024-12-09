<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use App\Models\DetailRetur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returs = Retur::all();  // Mengambil data retur beserta info penerimaan dan user penerima
        return view('retur.index', compact('returs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id_penerimaan)
    {
        // Validasi jika id_penerimaan ada
        $request->validate([
            'alasan' => 'required|string|max:255',  // Validasi alasan retur jika perlu
        ]);

        // Mendapatkan id_user (misalnya ID user yang sedang login)
        $id_user = Auth::id();
        $alasan = $request->input('alasan');

        try {
            // Memanggil stored procedure untuk memproses retur
            DB::beginTransaction();  // Memulai transaksi
            DB::select('CALL sp_create_returr(?, ?, ?)', [$id_penerimaan, $id_user, $alasan]);
            DB::commit();  // Commit transaksi jika berhasil

            return redirect()->back()->with('success', 'Retur berhasil diproses!');
        } catch (\Exception $e) {
            DB::rollBack();  // Rollback transaksi jika terjadi kesalahan
            dd($e);
            // Menampilkan pesan error
            return redirect()->route('penerimaan.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $retur = Retur::all()->findOrFail($id);
        $detailRetur = DetailRetur::where('idretur', $id)->get();


        foreach ($detailRetur as $detail) {
            $detail->load('barang');
         }
        return view('retur.detail', compact('retur', 'detailRetur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retur $retur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Retur $retur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retur $retur)
    {
        //
    }
}
