<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CarouselController extends Controller
{
    public function index(Request $request)
    {
        $query = Carousel::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $carousels = $query->orderBy('urutan', 'asc')->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $carousels->items(),
            'pagination' => [
                'current_page' => $carousels->currentPage(),
                'last_page' => $carousels->lastPage(),
                'per_page' => $carousels->perPage(),
                'total' => $carousels->total(),
                'from' => $carousels->firstItem(),
                'to' => $carousels->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        Log::info('Carousel store request:', $request->all());
        Log::info('Files:', $request->allFiles());
        
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:500',
                'link' => 'nullable|url|max:255',
                'urutan' => 'required|integer|min:0',
                'aktif' => 'boolean',
                'gambar' => 'nullable|image|max:2048',
            ]);
            
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'link' => $request->link,
                'urutan' => $request->urutan,
                'aktif' => $request->aktif ?? false,
            ];
            
            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('carousel', 'public');
                $data['gambar'] = $path;
                Log::info('Image stored at: ' . $path);
            }
            
            $carousel = Carousel::create($data);
            Log::info('Carousel created:', $carousel->toArray());
            
            return response()->json([
                'success' => true,
                'message' => 'Carousel berhasil disimpan',
                'data' => $carousel
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error storing carousel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        $carousel = Carousel::find($id);
        
        if (!$carousel) {
            return response()->json([
                'success' => false,
                'message' => 'Carousel tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $carousel
        ]);
    }
    
    public function update(Request $request, $id)
    {
        Log::info('Carousel update request for ID: ' . $id, $request->all());
        Log::info('Files:', $request->allFiles());
        
        $carousel = Carousel::find($id);
        
        if (!$carousel) {
            Log::error('Carousel not found with ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'Carousel tidak ditemukan'
            ], 404);
        }
        
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:500',
                'link' => 'nullable|url|max:255',
                'urutan' => 'required|integer|min:0',
                'aktif' => 'boolean',
                'gambar' => 'nullable|image|max:2048',
            ]);
            
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'link' => $request->link,
                'urutan' => $request->urutan,
                'aktif' => $request->aktif ?? false,
            ];
            
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($carousel->gambar) {
                    Storage::disk('public')->delete($carousel->gambar);
                    Log::info('Deleted old image: ' . $carousel->gambar);
                }
                $path = $request->file('gambar')->store('carousel', 'public');
                $data['gambar'] = $path;
                Log::info('New image stored at: ' . $path);
            }
            
            $carousel->update($data);
            Log::info('Carousel updated:', $carousel->toArray());
            
            return response()->json([
                'success' => true,
                'message' => 'Carousel berhasil diperbarui',
                'data' => $carousel
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating carousel: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        $carousel = Carousel::find($id);
        
        if (!$carousel) {
            return response()->json([
                'success' => false,
                'message' => 'Carousel tidak ditemukan'
            ], 404);
        }
        
        // Delete image if exists
        if ($carousel->gambar) {
            Storage::disk('public')->delete($carousel->gambar);
        }
        
        $carousel->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Carousel berhasil dihapus'
        ]);
    }
    
    public function toggleStatus($id)
    {
        $carousel = Carousel::find($id);
        
        if (!$carousel) {
            return response()->json([
                'success' => false,
                'message' => 'Carousel tidak ditemukan'
            ], 404);
        }
        
        $carousel->update(['aktif' => !$carousel->aktif]);
        $status = $carousel->aktif ? 'dinonaktifkan' : 'diaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "Carousel berhasil {$status}",
            'data' => $carousel
        ]);
    }
}