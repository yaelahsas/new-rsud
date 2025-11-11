<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Galeri::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('kategori', $request->kategori);
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $galeris = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $galeris->items(),
            'pagination' => [
                'current_page' => $galeris->currentPage(),
                'last_page' => $galeris->lastPage(),
                'per_page' => $galeris->perPage(),
                'total' => $galeris->total(),
                'from' => $galeris->firstItem(),
                'to' => $galeris->lastItem(),
            ]
        ]);
    }
    
    public function kategoris()
    {
        $kategoris = Galeri::select('kategori')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori')
            ->toArray();
            
        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'kategori' => 'nullable|string|max:100',
            'gambar' => 'required|image|max:2048',
        ]);
        
        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ];
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('galeri', 'public');
            $data['gambar'] = $path;
        }
        
        $galeri = Galeri::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil disimpan',
            'data' => $galeri
        ]);
    }
    
    public function show($id)
    {
        $galeri = Galeri::find($id);
        
        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $galeri
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $galeri = Galeri::find($id);
        
        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'kategori' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ];
        
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($galeri->gambar) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $path = $request->file('gambar')->store('galeri', 'public');
            $data['gambar'] = $path;
        }
        
        $galeri->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil diperbarui',
            'data' => $galeri
        ]);
    }
    
    public function destroy($id)
    {
        $galeri = Galeri::find($id);
        
        if (!$galeri) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }
        
        // Delete image if exists
        if ($galeri->gambar) {
            Storage::disk('public')->delete($galeri->gambar);
        }
        
        $galeri->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil dihapus'
        ]);
    }
}