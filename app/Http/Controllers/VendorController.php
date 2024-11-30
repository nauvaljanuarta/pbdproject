<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{

    public function index()
    {

        $vendors = Vendor::all();
        return view('admin.vendor', compact('vendors'));
    }

    public function store(Request $request)
    {
        DB::statement('CALL sp_create_vendor(?, ?, ?)', [
            $request->nama_vendor,
            $request->badan_hukum,
            $request->status
        ]);

        return redirect()->back()->with('success', 'Vendor created successfully!');
    }

    public function update(Request $request, $id)
    {
        DB::statement('CALL sp_update_vendor(?, ?, ?, ?)', [
            $id,
            $request->nama_vendor,
            $request->badan_hukum,
            $request->status
        ]);

        return redirect()->back()->with('success', 'Vendor updated successfully!');
    }


    public function destroy($id)
    {
        DB::statement('CALL sp_delete_vendor(?)', [$id]);

        return redirect()->back()->with('success', 'Vendor deleted successfully!');
    }
}
