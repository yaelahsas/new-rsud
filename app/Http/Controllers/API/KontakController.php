<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index(Request $request)
    {
        $query = Kontak::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_kontak', 'like', '%' . $search . '%')
                  ->orWhere('label', 'like', '%' . $search . '%')
                  ->orWhere('value', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by jenis kontak
        if ($request->has('jenis_kontak') && !empty($request->jenis_kontak)) {
            $query->where('jenis_kontak', $request->jenis_kontak);
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $kontaks = $query->orderBy('jenis_kontak', 'asc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $kontaks->items(),
            'pagination' => [
                'current_page' => $kontaks->currentPage(),
                'last_page' => $kontaks->lastPage(),
                'per_page' => $kontaks->perPage(),
                'total' => $kontaks->total(),
                'from' => $kontaks->firstItem(),
                'to' => $kontaks->lastItem(),
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kontak' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'value' => 'required|string',
            'icon' => 'nullable|string|max:255',
        ]);
        
        $kontak = Kontak::create([
            'jenis_kontak' => $request->jenis_kontak,
            'label' => $request->label,
            'value' => $request->value,
            'icon' => $request->icon,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil disimpan',
            'data' => $kontak
        ]);
    }
    
    public function show($id)
    {
        $kontak = Kontak::find($id);
        
        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Kontak tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $kontak
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $kontak = Kontak::find($id);
        
        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Kontak tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'jenis_kontak' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'value' => 'required|string',
            'icon' => 'nullable|string|max:255',
        ]);
        
        $kontak->update([
            'jenis_kontak' => $request->jenis_kontak,
            'label' => $request->label,
            'value' => $request->value,
            'icon' => $request->icon,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil diperbarui',
            'data' => $kontak
        ]);
    }
    
    public function destroy($id)
    {
        $kontak = Kontak::find($id);
        
        if (!$kontak) {
            return response()->json([
                'success' => false,
                'message' => 'Kontak tidak ditemukan'
            ], 404);
        }
        
        $kontak->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Kontak berhasil dihapus'
        ]);
    }
}