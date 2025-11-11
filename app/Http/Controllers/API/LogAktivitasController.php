<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Log_aktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Log_aktivitas::with('user');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('aksi', 'like', '%' . $search . '%')
                  ->orWhere('modul', 'like', '%' . $search . '%')
                  ->orWhere('detail', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Filter by modul
        if ($request->has('modul') && !empty($request->modul)) {
            $query->where('modul', $request->modul);
        }
        
        // Filter by user
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by date range
        if ($request->has('tanggal_mulai') && !empty($request->tanggal_mulai)) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_selesai') && !empty($request->tanggal_selesai)) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $logs->items(),
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
                'from' => $logs->firstItem(),
                'to' => $logs->lastItem(),
            ]
        ]);
    }
    
    public function modules()
    {
        $modules = Log_aktivitas::select('modul')
            ->distinct()
            ->whereNotNull('modul')
            ->orderBy('modul')
            ->pluck('modul')
            ->toArray();
            
        return response()->json([
            'success' => true,
            'data' => $modules
        ]);
    }
    
    public function users()
    {
        $users = User::select('id', 'nama', 'email')
            ->orderBy('nama')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
    
    public function show($id)
    {
        $log = Log_aktivitas::with('user')->find($id);
        
        if (!$log) {
            return response()->json([
                'success' => false,
                'message' => 'Log aktivitas tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $log
        ]);
    }
    
    public function destroy($id)
    {
        $log = Log_aktivitas::find($id);
        
        if (!$log) {
            return response()->json([
                'success' => false,
                'message' => 'Log aktivitas tidak ditemukan'
            ], 404);
        }
        
        $log->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Log aktivitas berhasil dihapus'
        ]);
    }
    
    public function clearOldLogs(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);
        
        $date = now()->subDays($request->days);
        $deletedCount = Log_aktivitas::where('created_at', '<', $date)->delete();
        
        return response()->json([
            'success' => true,
            'message' => "Berhasil menghapus {$deletedCount} log aktivitas yang lebih lama dari {$request->days} hari",
            'deleted_count' => $deletedCount
        ]);
    }
}