<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Inovasi;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('inovasi');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('pesan', 'like', '%' . $search . '%')
                  ->orWhereHas('inovasi', function($inovasiQuery) use ($search) {
                      $inovasiQuery->where('nama_inovasi', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Filter by inovasi
        if ($request->has('inovasi_id') && !empty($request->inovasi_id)) {
            $query->where('inovasi_id', $request->inovasi_id);
        }
        
        // Filter by rating
        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', $request->rating);
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $reviews = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $reviews->items(),
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
                'from' => $reviews->firstItem(),
                'to' => $reviews->lastItem(),
            ]
        ]);
    }
    
    public function inovasis()
    {
        $inovasis = Inovasi::select('id', 'nama_inovasi')
            ->where('status', 'aktif')
            ->orderBy('nama_inovasi')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $inovasis
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'required|string',
            'inovasi_id' => 'required|integer|exists:inovasis,id',
        ]);
        
        $review = Review::create([
            'nama' => $request->nama,
            'rating' => $request->rating,
            'pesan' => $request->pesan,
            'inovasi_id' => $request->inovasi_id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Review berhasil disimpan',
            'data' => $review->load('inovasi')
        ]);
    }
    
    public function show($id)
    {
        $review = Review::with('inovasi')->find($id);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'required|string',
            'inovasi_id' => 'required|integer|exists:inovasis,id',
        ]);
        
        $review->update([
            'nama' => $request->nama,
            'rating' => $request->rating,
            'pesan' => $request->pesan,
            'inovasi_id' => $request->inovasi_id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diperbarui',
            'data' => $review->load('inovasi')
        ]);
    }
    
    public function destroy($id)
    {
        $review = Review::find($id);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan'
            ], 404);
        }
        
        $review->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus'
        ]);
    }
}