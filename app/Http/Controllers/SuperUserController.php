<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\SuperUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperUserController extends Controller
{
    public function index()
    {
        $superUsers = SuperUser::all();
        return response()->json($superUsers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:super_users,email',
            'password' => 'required|min:6',
        ]);

        $superUser = SuperUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'SuperUser created successfully', 'superUser' => $superUser], 201);
    }

    public function show($id)
    {
        $superUser = SuperUser::find($id);
        if (!$superUser) {
            return response()->json(['message' => 'SuperUser not found'], 404);
        }
        return response()->json($superUser);
    }

    public function update(Request $request, $id)
    {
        $superUser = SuperUser::find($id);
        if (!$superUser) {
            return response()->json(['message' => 'SuperUser not found'], 404);
        }

        $request->validate([
            'name' => 'string',
            'email' => 'email|unique:super_users,email,' . $id,
            'password' => 'min:6',
        ]);

        $superUser->update($request->all());

        return response()->json(['message' => 'SuperUser updated successfully', 'superUser' => $superUser]);
    }

    public function destroy($id)
    {
        $superUser = SuperUser::find($id);
        if (!$superUser) {
            return response()->json(['message' => 'SuperUser not found'], 404);
        }

        $superUser->delete();

        return response()->json(['message' => 'SuperUser deleted successfully']);
    }
    public function assignRole(Request $request, $superUserId)
    {
        $superUser = SuperUser::find($superUserId);
        if (!$superUser) {
            return response()->json(['message' => 'SuperUser not found'], 404);
        }

        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $superUser->roles()->attach($role);
        return response()->json(['message' => 'Role assigned successfully']);
    }

    public function removeRole(Request $request, $superUserId)
    {
        $superUser = SuperUser::find($superUserId);
        if (!$superUser) {
            return response()->json(['message' => 'SuperUser not found'], 404);
        }

        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $superUser->roles()->detach($role);
        return response()->json(['message' => 'Role removed successfully']);
    }

    public function getRoles($superUserId)
    {
        $superUser = SuperUser::find($superUserId);
        if (!$superUser) {
            return response()->json(['message' => 'SuperUser not found'], 404);
        }

        return response()->json($superUser->roles);
    }
}