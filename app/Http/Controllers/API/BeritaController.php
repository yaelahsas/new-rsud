<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori_berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with(['kategori', 'author']);
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
                //   ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $beritas = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $beritas->items(),
            'pagination' => [
                'current_page' => $beritas->currentPage(),
                'last_page' => $beritas->lastPage(),
                'per_page' => $beritas->perPage(),
                'total' => $beritas->total(),
                'from' => $beritas->firstItem(),
                'to' => $beritas->lastItem(),
            ]
        ]);
    }
    
    public function kategoris()
    {
        $kategoris = Kategori_berita::all();
        
        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|min:3|max:255',
                'kategori_id' => 'required|integer|exists:kategori_beritas,id',
                'isi' => 'required|string',
                'thumbnail' => 'nullable|image|max:2048',
                'publish' => 'boolean',
                'tanggal_publish' => 'nullable|date',
            ]);
            
            $path = null;
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('artikel', 'public');
            }
            
            $berita = Berita::create([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'kategori_id' => $request->kategori_id,
                'isi' => $request->isi,
                'thumbnail' => $path,
                'publish' => $request->publish ?? false,
                'tanggal_publish' => $request->tanggal_publish ?: now(),
                'created_by' => Auth::id(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil disimpan',
                'data' => $berita->load(['kategori', 'author'])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        $berita = Berita::with(['kategori', 'author'])->find($id);
        
        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }
    
    public function update(Request $request, $id)
    {
        try {
            \Log::info('Updating berita with ID: ' . $id);
            \Log::info('Request data: ', $request->all());
            \Log::info('Request files: ', $request->allFiles());
            
            $berita = Berita::find($id);
            
            if (!$berita) {
                \Log::error('Berita not found with ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan'
                ], 404);
            }
            
            \Log::info('Original berita data: ', $berita->toArray());
            
            // Siapkan data update - update semua field yang ada di request
            $updateData = [];
            
            // Update judul dan slug (selalu update jika ada di request, bahkan jika kosong)
            if ($request->has('judul')) {
                $updateData['judul'] = $request->judul;
                $updateData['slug'] = Str::slug($request->judul);
                \Log::info('Updating judul to: ' . $request->judul);
            }
            
            // Update kategori_id (selalu update jika ada di request)
            if ($request->has('kategori_id')) {
                $updateData['kategori_id'] = $request->kategori_id;
                \Log::info('Updating kategori_id to: ' . $request->kategori_id);
            }
            
            // Update isi (selalu update jika ada di request)
            if ($request->has('isi')) {
                $updateData['isi'] = $request->isi;
                \Log::info('Updating isi content');
            }
            
            // Update thumbnail jika ada file baru
            if ($request->hasFile('thumbnail')) {
                // Hapus thumbnail lama kalau ada
                if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                    Storage::disk('public')->delete($berita->thumbnail);
                    \Log::info('Deleted old thumbnail: ' . $berita->thumbnail);
                }

                // Simpan yang baru
                $path = $request->file('thumbnail')->store('artikel', 'public');
                $updateData['thumbnail'] = $path;
                \Log::info('Saved new thumbnail: ' . $path);
            } else {
                \Log::info('No new thumbnail file uploaded');
            }
            
            // Selalu update publish status
            $updateData['publish'] = $request->boolean('publish', false);
            \Log::info('Updating publish status to: ' . ($request->boolean('publish', false) ? 'true' : 'false'));
            
            // Update tanggal_publish (selalu update jika ada di request)
            if ($request->has('tanggal_publish')) {
                $updateData['tanggal_publish'] = $request->tanggal_publish ?: null;
                \Log::info('Updating tanggal_publish to: ' . ($request->tanggal_publish ?: 'null'));
            }

            \Log::info('Final update data: ', $updateData);

            // Update data
            $berita->update($updateData);

            // Reload model dengan data terbaru untuk mendapatkan thumbnail yang benar
            $updatedBerita = $berita->fresh(['kategori', 'author']);
            \Log::info('Updated berita data: ', $updatedBerita->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui',
                'data' => $updatedBerita,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        $berita = Berita::find($id);
        
        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }
        
        // Delete thumbnail if exists
        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }
        
        $berita->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}
