<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kategori_berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori_berita::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kategori', 'like', '%' . $search . '%')
                   ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $kategoris = $query->withCount('beritas')->orderBy('nama_kategori', 'asc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $kategoris->items(),
            'pagination' => [
                'current_page' => $kategoris->currentPage(),
                'last_page' => $kategoris->lastPage(),
                'per_page' => $kategoris->perPage(),
                'total' => $kategoris->total(),
                'from' => $kategoris->firstItem(),
                'to' => $kategoris->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_beritas,nama_kategori',
            'slug' => 'required|string|max:255|unique:kategori_beritas,slug',
        ]);
        
        $kategori = Kategori_berita::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => $request->slug,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil disimpan',
            'data' => $kategori->loadCount('beritas')
        ]);
    }
    
    public function show($id)
    {
        $kategori = Kategori_berita::withCount('beritas')->find($id);
        
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $kategori = Kategori_berita::find($id);
        
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_beritas,nama_kategori,' . $id,
            'slug' => 'required|string|max:255|unique:kategori_beritas,slug,' . $id,
        ]);
        
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => $request->slug,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $kategori->loadCount('beritas')
        ]);
    }
    
    public function destroy($id)
    {
        $kategori = Kategori_berita::withCount('beritas')->find($id);
        
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
        
        // Cek apakah kategori digunakan oleh berita
        if ($kategori->beritas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh berita'
            ], 422);
        }
        
        $kategori->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}