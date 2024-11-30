<?php


namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function index()
    {

        $roles = Role::all();
        return view('admin.role', compact('roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:100',
        ]);

        DB::statement('CALL sp_create_role(?)', [
            $request->nama_role,
        ]);

        return redirect()->back()->with('success', 'Role created successfully!');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_role' => 'required|string|max:100',
        ]);

        DB::statement('CALL sp_update_role(?, ?)', [
            $id,
            $request->nama_role,
        ]);


        return redirect()->back()->with('success', 'Role updated successfully!');
    }


    public function destroy($id)
    {

        DB::statement('CALL sp_delete_role(?)', [$id]);

        return redirect()->back()->with('success', 'Role deleted successfully!');
    }
}
