<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokter::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('spesialis', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $dokters = $query->with('poli')->orderBy('nama', 'asc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $dokters->items(),
            'pagination' => [
                'current_page' => $dokters->currentPage(),
                'last_page' => $dokters->lastPage(),
                'per_page' => $dokters->perPage(),
                'total' => $dokters->total(),
                'from' => $dokters->firstItem(),
                'to' => $dokters->lastItem(),
            ]
        ]);
    }
    
    public function polis()
    {
        $polis = Poli::where('status', 'aktif')->orderBy('nama_poli', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $polis
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'poli_id' => 'required|integer|exists:polis,id',
            'kontak' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'nama' => $request->nama,
            'spesialis' => $request->spesialis,
            'poli_id' => $request->poli_id,
            'kontak' => $request->kontak,
            'status' => $request->status,
        ];
        
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('dokter', 'public');
            $data['foto'] = $path;
        }
        
        $dokter = Dokter::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Dokter berhasil disimpan',
            'data' => $dokter->load('poli')
        ]);
    }
    
    public function show($id)
    {
        $dokter = Dokter::with('poli')->find($id);
        
        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $dokter
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $dokter = Dokter::find($id);
        
        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'poli_id' => 'required|integer|exists:polis,id',
            'kontak' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'foto' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'nama' => $request->nama,
            'spesialis' => $request->spesialis,
            'poli_id' => $request->poli_id,
            'kontak' => $request->kontak,
            'status' => $request->status,
        ];
        
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $path = $request->file('foto')->store('dokter', 'public');
            $data['foto'] = $path;
        }
        
        $dokter->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Dokter berhasil diperbarui',
            'data' => $dokter->load('poli')
        ]);
    }
    
    public function destroy($id)
    {
        $dokter = Dokter::withCount('jadwals')->find($id);
        
        if (!$dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan'
            ], 404);
        }
        
        // Cek apakah dokter memiliki jadwal
        if ($dokter->jadwals_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak dapat dihapus karena masih memiliki jadwal praktik'
            ], 422);
        }
        
        // Delete photo if exists
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }
        
        $dokter->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Dokter berhasil dihapus'
        ]);
    }
}