<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{

    public function index()
    {
        $satuan = Satuan::all();
        return view('admin.satuan', compact('satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:45',
            'status' => 'required|boolean',
        ]);

        DB::statement('CALL sp_create_satuan(?, ?)', [
            $request->nama_satuan,
            $request->status,
        ]);

        return redirect()->back()->with('satuan creatted successfully');
    }

    // Update a satuan (call sp_update_satuan stored procedure)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:45',
            'status' => 'required|boolean',
        ]);

        DB::statement('CALL sp_update_satuan(?, ?, ?)', [
            $id,
            $request->nama_satuan,
            $request->status,
        ]);

        return redirect()->back()->with('satuan creatted successfully');
    }


    // Delete a satuan (call sp_delete_satuan stored procedure)
    public function destroy($id)
    {
        DB::statement('CALL sp_delete_satuan(?)', [$id]);

        return redirect()->back()->with('satuan creatted successfully');
    }

}
