<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_poli;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class JadwalPoliController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal_poli::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dokter', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                })->orWhereHas('poli', function ($q) use ($search) {
                    $q->where('nama_poli', 'like', '%' . $search . '%');
                })->orWhere('hari', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 10;
        $jadwals = $query->with(['dokter', 'poli'])
            ->orderBy('hari', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $jadwals->items(),
            'pagination' => [
                'current_page' => $jadwals->currentPage(),
                'last_page' => $jadwals->lastPage(),
                'per_page' => $jadwals->perPage(),
                'total' => $jadwals->total(),
                'from' => $jadwals->firstItem(),
                'to' => $jadwals->lastItem(),
            ]
        ]);
    }
    
    public function dokters()
    {
        $dokters = Dokter::where('status', 'aktif')->orderBy('nama', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $dokters
        ]);
    }
    
    public function polis()
    {
        $polis = Poli::where('status', 'aktif')->orderBy('nama_poli', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $polis
        ]);
    }
    
    public function store(Request $request)
    {
        // Check if this is a multiple schedule request
        if ($request->has('multiple_days') && is_array($request->multiple_days)) {
            return $this->storeMultipleSchedules($request);
        }
        
        $request->validate([
            'dokter_id' => 'required|integer|exists:dokters,id',
            'poli_id' => 'required|integer|exists:polis,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'is_cuti' => 'boolean',
            'tanggal_cuti' => 'nullable|date|required_if:is_cuti,true',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $data = [
            'dokter_id' => $request->dokter_id,
            'poli_id' => $request->poli_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_cuti' => $request->is_cuti,
            'keterangan' => $request->keterangan,
        ];
        
        if ($request->is_cuti) {
            $data['tanggal_cuti'] = $request->tanggal_cuti;
        } else {
            $data['tanggal_cuti'] = null;
        }
        
        $jadwal = Jadwal_poli::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil disimpan',
            'data' => $jadwal->load(['dokter', 'poli'])
        ]);
    }
    
    private function storeMultipleSchedules(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|integer|exists:dokters,id',
            'poli_id' => 'required|integer|exists:polis,id',
            'multiple_days' => 'required|array|min:1',
            'multiple_days.*' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'is_cuti' => 'boolean',
            'tanggal_cuti' => 'nullable|date|required_if:is_cuti,true',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $schedules = [];
        $errors = [];
        
        foreach ($request->multiple_days as $hari) {
            // Check if schedule already exists for this doctor on this day
            $existingSchedule = Jadwal_poli::where('dokter_id', $request->dokter_id)
                ->where('hari', $hari)
                ->first();
                
            if ($existingSchedule) {
                $errors[] = "Jadwal untuk hari {$hari} sudah ada untuk dokter ini";
                continue;
            }
            
            $data = [
                'dokter_id' => $request->dokter_id,
                'poli_id' => $request->poli_id,
                'hari' => $hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'is_cuti' => $request->is_cuti,
                'keterangan' => $request->keterangan,
            ];
            
            if ($request->is_cuti) {
                $data['tanggal_cuti'] = $request->tanggal_cuti;
            } else {
                $data['tanggal_cuti'] = null;
            }
            
            $schedules[] = Jadwal_poli::create($data);
        }
        
        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'Beberapa jadwal gagal disimpan',
                'errors' => $errors
            ], 422);
        }
        
        return response()->json([
            'success' => true,
            'message' => count($schedules) . ' jadwal berhasil disimpan',
            'data' => $schedules
        ]);
    }
    
    public function show($id)
    {
        $jadwal = Jadwal_poli::with(['dokter', 'poli'])->find($id);
        
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $jadwal,
            'related_records' => 0 // Jadwal poli tidak memiliki data terkait yang perlu dicek
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal_poli::find($id);
        
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }
        
        $request->validate([
            'dokter_id' => 'required|integer|exists:dokters,id',
            'poli_id' => 'required|integer|exists:polis,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'is_cuti' => 'boolean',
            'tanggal_cuti' => 'nullable|date|required_if:is_cuti,true',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $data = [
            'dokter_id' => $request->dokter_id,
            'poli_id' => $request->poli_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'is_cuti' => $request->is_cuti,
            'keterangan' => $request->keterangan,
        ];
        
        if ($request->is_cuti) {
            $data['tanggal_cuti'] = $request->tanggal_cuti;
        } else {
            $data['tanggal_cuti'] = null;
        }
        
        $jadwal->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $jadwal->load(['dokter', 'poli'])
        ]);
    }
    
    public function destroy($id)
    {
        $jadwal = Jadwal_poli::find($id);
        
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], 404);
        }
        
        $jadwal->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
}