<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('Backend.user.index');
    }

    public function data(Request $request)
    {
        $data = User::select(['id', 'name', 'email', 'role', 'created_at']);

        return DataTables::of($data)
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('action', function ($row) {
                return view('partials.action', compact('row'));
            })
            ->rawColumns(['action']) // biar tombol HTML tetap dirender
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'required',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
