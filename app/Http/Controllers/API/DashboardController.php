<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use App\Models\Carousel;
use App\Models\Jadwal_poli;

class DashboardController extends Controller
{
    public function stats()
    {
        $stats = [
            'total_berita' => Berita::count(),
            'berita_publish' => Berita::where('publish', true)->count(),
            'berita_draft' => Berita::where('publish', false)->count(),
            'total_dokter' => Dokter::count(),
            'dokter_aktif' => Dokter::where('status', 'aktif')->count(),
            'total_poli' => Poli::count(),
            'poli_aktif' => Poli::where('status', 'aktif')->count(),
            'total_user' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'editor_users' => User::where('role', 'editor')->count(),
            'total_carousel' => Carousel::count(),
            'carousel_aktif' => Carousel::where('aktif', true)->count(),
            'total_jadwal' => Jadwal_poli::count(),
            'jadwal_hari_ini' => Jadwal_poli::where('hari', now()->format('l'))->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
    
    public function recentBerita()
    {
        $recent_berita = Berita::with('kategori', 'author')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $recent_berita
        ]);
    }
    
    public function recentUsers()
    {
        $recent_users = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $recent_users
        ]);
    }
    
    public function monthlyData()
    {
        $berita_per_month = Berita::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        // Fill missing months with 0
        $monthly_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_data[] = $berita_per_month[$i] ?? 0;
        }
        
        return response()->json([
            'success' => true,
            'data' => $monthly_data
        ]);
    }
}