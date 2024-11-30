<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    public function detail()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.user', compact('users','roles'));
    }


    public function store(Request $request)
    {

        DB::statement('CALL sp_create_user(?, ?, ?)', [
            $request->username,
            $request->password,
            $request->idrole,
        ]);
        

        return redirect()->back()->with('success', 'User created successfully!');
    }

    // Update user details
    public function update(Request $request, $id)
    {

        $request->validate([
            'idrole' => 'required|integer|exists:role,idrole',  // Ensure role exists
            'username' => 'required|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',  // Optional password
        ]);

        // Call the stored procedure to update the user
        DB::statement('CALL sp_update_user(?, ?, ?, ?)', [
            $id,
            $request->idrole,
            $request->username,
            $request->password ? $request->password : null,  // Only update password if provided
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    // Delete a user
    public function destroy($id)
    {
        // Call the stored procedure to delete the user
        DB::statement('CALL sp_delete_user(?)', [$id]);

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
