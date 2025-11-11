<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by status
        if ($request->has('aktif') && $request->aktif !== '') {
            $query->where('aktif', $request->boolean('aktif'));
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $pengumumen = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $pengumumen->items(),
            'pagination' => [
                'current_page' => $pengumumen->currentPage(),
                'last_page' => $pengumumen->lastPage(),
                'per_page' => $pengumumen->perPage(),
                'total' => $pengumumen->total(),
                'from' => $pengumumen->firstItem(),
                'to' => $pengumumen->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif' => 'boolean',
        ]);
        
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'aktif' => $request->aktif ?? true,
        ];
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pengumuman', 'public');
            $data['gambar'] = $path;
        }
        
        $pengumuman = Pengumuman::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil disimpan',
            'data' => $pengumuman
        ]);
    }
    
    public function show($id)
    {
        $pengumuman = Pengumuman::find($id);
        
        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $pengumuman
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::find($id);
        
        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif' => 'boolean',
        ]);
        
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'aktif' => $request->aktif,
        ];
        
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $path = $request->file('gambar')->store('pengumuman', 'public');
            $data['gambar'] = $path;
        }
        
        $pengumuman->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil diperbarui',
            'data' => $pengumuman
        ]);
    }
    
    public function destroy($id)
    {
        $pengumuman = Pengumuman::find($id);
        
        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
        
        // Delete image if exists
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }
        
        $pengumuman->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil dihapus'
        ]);
    }
    
    public function toggleStatus($id)
    {
        $pengumuman = Pengumuman::find($id);
        
        if (!$pengumuman) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumuman tidak ditemukan'
            ], 404);
        }
        
        $pengumuman->update(['aktif' => !$pengumuman->aktif]);
        $status = $pengumuman->aktif ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "Pengumuman berhasil {$status}",
            'data' => $pengumuman
        ]);
    }
}