<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Margin;
use App\Models\User;
class MarginController extends Controller
{

    public function index()
    {
        $margins = Margin::all(); // Ambil data dari view
        $users = User::all(); // Ambil data user untuk dropdown
        return view('admin.margin', compact('margins', 'users'));
    }

    public function store(Request $request)
    {
        $iduser =Auth::id();

        DB::statement('CALL sp_create_margin_penjualan(?, ?, ?)', [
            $iduser,    
            $request->persen,
            $request->status
        ]);

        return redirect()->back()->with('success', 'Margin Penjualan berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'persen' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        // Memanggil prosedur pembaruan data
        DB::statement('CALL sp_update_margin_penjualan(?, ?, ?)', [
            $id,
            $request->persen,
            $request->status
        ]);

        return redirect()->back()->with('success', 'Margin Penjualan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Memanggil prosedur penghapusan data
        DB::statement('CALL sp_delete_margin_penjualan(?)', [$id]);

        return redirect()->back()->with('success', 'Margin Penjualan berhasil dihapus!');
    }
}
