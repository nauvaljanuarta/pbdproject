<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $satuan = DB::select('SELECT * FROM satuan');
        return view('admin.satuan', ['satuan' => $satuan]);

    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required',
            'status' => 'required|boolean',
        ]);

        $maxId = DB::table('satuan')->max('idsatuan');
        $newId = $maxId ? $maxId + 1 : 1;


        DB::insert('INSERT INTO satuan (idsatuan, nama_satuan, status) VALUES (?, ?, ?)', [$newId, $request->nama_satuan, $request->status]);

        return redirect()->back()->with('success', 'Satuan added successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Log::info("Updating satuan with ID: $id", [
            'nama_satuan' => $request->nama_satuan,
            'status' => $request->status,
        ]);

        // Execute the update query
        $updated = DB::update('UPDATE satuan SET nama_satuan = ?, status = ? WHERE idsatuan = ?', [
            $request->nama_satuan,
            $request->status,
            $id
        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Satuan updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update Satuan. Please try again.');
        }
    }

    public function destroy($id)
    {

        $count = DB::table('barang')->where('idsatuan', $id)->count();

        if ($count > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus Satuan. Terdapat data barang yang terkait.');
        }


        DB::delete('DELETE FROM satuan WHERE idsatuan = ?', [$id]);

        return redirect()->back()->with('delete', 'Satuan deleted successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

}
