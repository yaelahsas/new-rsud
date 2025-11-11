<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $query = Setting::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('key', 'like', '%' . $search . '%')
                  ->orWhere('value', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('key', 'like', $request->category . '%');
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $settings = $query->orderBy('key', 'asc')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $settings->items(),
            'pagination' => [
                'current_page' => $settings->currentPage(),
                'last_page' => $settings->lastPage(),
                'per_page' => $settings->perPage(),
                'total' => $settings->total(),
                'from' => $settings->firstItem(),
                'to' => $settings->lastItem(),
            ]
        ]);
    }
    
    public function categories()
    {
        $categories = Setting::selectRaw('SUBSTRING_INDEX(key, 1, LOCATE(".", key) - 1) as category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();
            
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);
        
        $setting = Setting::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Setting berhasil disimpan',
            'data' => $setting
        ]);
    }
    
    public function show($id)
    {
        $setting = Setting::find($id);
        
        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Setting tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);
        
        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Setting tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);
        
        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Setting berhasil diperbarui',
            'data' => $setting
        ]);
    }
    
    public function destroy($id)
    {
        $setting = Setting::find($id);
        
        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Setting tidak ditemukan'
            ], 404);
        }
        
        $setting->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Setting berhasil dihapus'
        ]);
    }
    
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|max:255',
            'settings.*.value' => 'required|string',
        ]);
        
        $updatedCount = 0;
        foreach ($request->settings as $settingData) {
            $setting = Setting::where('key', $settingData['key'])->first();
            
            if ($setting) {
                $setting->update(['value' => $settingData['value']]);
                $updatedCount++;
            } else {
                Setting::create([
                    'key' => $settingData['key'],
                    'value' => $settingData['value'],
                ]);
                $updatedCount++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "{$updatedCount} setting berhasil diperbarui",
            'updated_count' => $updatedCount
        ]);
    }
}