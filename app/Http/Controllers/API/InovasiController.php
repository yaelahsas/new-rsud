<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InovasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Inovasi::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_inovasi', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $inovasis = $query->withCount('reviews')->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $inovasis->items(),
            'pagination' => [
                'current_page' => $inovasis->currentPage(),
                'last_page' => $inovasis->lastPage(),
                'per_page' => $inovasis->perPage(),
                'total' => $inovasis->total(),
                'from' => $inovasis->firstItem(),
                'to' => $inovasis->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'nullable|url|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'gambar' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'nama_inovasi' => $request->nama_inovasi,
            'slug' => Str::slug($request->nama_inovasi),
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'status' => $request->status,
        ];
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('inovasi', 'public');
            $data['gambar'] = $path;
        }
        
        $inovasi = Inovasi::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Inovasi berhasil disimpan',
            'data' => $inovasi->loadCount('reviews')
        ]);
    }
    
    public function show($id)
    {
        $inovasi = Inovasi::withCount('reviews')->find($id);
        
        if (!$inovasi) {
            return response()->json([
                'success' => false,
                'message' => 'Inovasi tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $inovasi
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $inovasi = Inovasi::find($id);
        
        if (!$inovasi) {
            return response()->json([
                'success' => false,
                'message' => 'Inovasi tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'nullable|url|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'gambar' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'nama_inovasi' => $request->nama_inovasi,
            'slug' => Str::slug($request->nama_inovasi),
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'status' => $request->status,
        ];
        
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($inovasi->gambar) {
                Storage::disk('public')->delete($inovasi->gambar);
            }
            $path = $request->file('gambar')->store('inovasi', 'public');
            $data['gambar'] = $path;
        }
        
        $inovasi->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Inovasi berhasil diperbarui',
            'data' => $inovasi->loadCount('reviews')
        ]);
    }
    
    public function destroy($id)
    {
        $inovasi = Inovasi::withCount('reviews')->find($id);
        
        if (!$inovasi) {
            return response()->json([
                'success' => false,
                'message' => 'Inovasi tidak ditemukan'
            ], 404);
        }
        
        // Check if inovasi has reviews
        if ($inovasi->reviews_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Inovasi tidak dapat dihapus karena memiliki review'
            ], 422);
        }
        
        // Delete image if exists
        if ($inovasi->gambar) {
            Storage::disk('public')->delete($inovasi->gambar);
        }
        
        $inovasi->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Inovasi berhasil dihapus'
        ]);
    }
    
    public function toggleStatus($id)
    {
        $inovasi = Inovasi::find($id);
        
        if (!$inovasi) {
            return response()->json([
                'success' => false,
                'message' => 'Inovasi tidak ditemukan'
            ], 404);
        }
        
        $newStatus = $inovasi->status === 'aktif' ? 'nonaktif' : 'aktif';
        $inovasi->update(['status' => $newStatus]);
        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "Inovasi berhasil {$statusText}",
            'data' => $inovasi
        ]);
    }
}