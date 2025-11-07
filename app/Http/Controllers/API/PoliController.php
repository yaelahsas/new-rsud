<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    public function index(Request $request)
    {
        $query = Poli::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_poli', 'like', '%' . $search . '%')
                  ->orWhere('ruangan', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $polis = $query->withCount('dokters')->orderBy('nama_poli', 'asc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $polis->items(),
            'pagination' => [
                'current_page' => $polis->currentPage(),
                'last_page' => $polis->lastPage(),
                'per_page' => $polis->perPage(),
                'total' => $polis->total(),
                'from' => $polis->firstItem(),
                'to' => $polis->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'ruangan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        $poli = Poli::create([
            'nama_poli' => $request->nama_poli,
            'ruangan' => $request->ruangan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Poli berhasil disimpan',
            'data' => $poli->loadCount('dokters')
        ]);
    }
    
    public function show($id)
    {
        $poli = Poli::withCount('dokters')->find($id);
        
        if (!$poli) {
            return response()->json([
                'success' => false,
                'message' => 'Poli tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $poli
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $poli = Poli::find($id);
        
        if (!$poli) {
            return response()->json([
                'success' => false,
                'message' => 'Poli tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'ruangan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        $poli->update([
            'nama_poli' => $request->nama_poli,
            'ruangan' => $request->ruangan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Poli berhasil diperbarui',
            'data' => $poli->loadCount('dokters')
        ]);
    }
    
    public function destroy($id)
    {
        $poli = Poli::withCount('dokters')->find($id);
        
        if (!$poli) {
            return response()->json([
                'success' => false,
                'message' => 'Poli tidak ditemukan'
            ], 404);
        }
        
        // Cek apakah poli memiliki dokter
        if ($poli->dokters_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Poli tidak dapat dihapus karena masih memiliki dokter'
            ], 422);
        }
        
        $poli->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Poli berhasil dihapus'
        ]);
    }
}