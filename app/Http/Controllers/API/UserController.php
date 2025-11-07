<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('role', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $users = $query->orderBy('nama', 'asc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:50',
            'password' => 'required|string|min:8',
        ]);
        
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|max:50',
            'password' => 'nullable|string|min:8',
        ]);
        
        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        
        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}