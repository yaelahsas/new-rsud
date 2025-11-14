<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori_berita;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\Jadwal_poli;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    /**
     * Get published articles for public frontend
     */
    public function articles(Request $request)
    {
        $query = Berita::with(['kategori', 'author'])
            ->where('publish', 1);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
                    // ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Date filter
        if ($request->has('date') && !empty($request->date)) {
            $query->whereMonth('tanggal_publish', '=', date('m', strtotime($request->date)))
                ->whereYear('tanggal_publish', '=', date('Y', strtotime($request->date)));
        }

        // Order by tanggal_publish if exists, otherwise created_at
        $query->orderBy('tanggal_publish', 'desc')
            ->orderBy('created_at', 'desc');

        // Pagination
        $perPage = $request->has('perPage') ? (int)$request->perPage : 9;
        $beritas = $query->paginate($perPage);

        // Transform data to match frontend expectations
        $articles = $beritas->getCollection()->map(function ($berita) {
            return [
                'id' => $berita->id,
                'title' => $berita->judul,
                'slug' => $berita->slug,
                'excerpt' => Str::limit(strip_tags($berita->isi), 150),
                'content' => $berita->isi,
                'thumbnail' => $berita->thumbnail ? asset('storage/' . $berita->thumbnail) : 'https://placehold.co/400x300',
                'category' => $berita->kategori ? [
                    'id' => $berita->kategori->id,
                    'name' => $berita->kategori->nama_kategori,
                    'slug' => $berita->kategori->slug
                ] : null,
                'author' => $berita->author ? [
                    'name' => $berita->author->name
                ] : null,
                'published_at' => $berita->tanggal_publish ?: $berita->created_at->format('Y-m-d'),
                'read_time' => $this->estimateReadTime($berita->isi),
                'views' => rand(100, 5000), // Placeholder since views field doesn't exist
                'featured' => rand(0, 10) > 8 // Random featured for demo
            ];
        });

        return response()->json([
            'success' => true,
            'articles' => $articles,
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

    /**
     * Get article categories for public frontend
     */
    public function articleCategories()
    {
        $categories = Kategori_berita::withCount('beritas')
            ->whereHas('beritas', function ($query) {
                $query->where('publish', true);
            })
            ->get()
            ->map(function ($kategori) {
                return [
                    'id' => $kategori->id,
                    'name' => $kategori->nama_kategori,
                    'slug' => $kategori->slug,
                    'count' => $kategori->beritas_count
                ];
            });

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Get single article by slug
     */
    public function article($slug)
    {
        $berita = Berita::with(['kategori', 'author'])
            ->where('slug', $slug)
            ->where('publish', true)
            ->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        $article = [
            'id' => $berita->id,
            'title' => $berita->judul,
            'slug' => $berita->slug,
            'excerpt' => Str::limit(strip_tags($berita->isi), 150),
            'content' => $berita->isi,
            'thumbnail' => $berita->thumbnail ? asset('storage/' . $berita->thumbnail) : 'https://placehold.co/400x300',
            'category' => $berita->kategori ? [
                'id' => $berita->kategori->id,
                'name' => $berita->kategori->nama_kategori,
                'slug' => $berita->kategori->slug
            ] : null,
            'author' => $berita->author ? [
                'name' => $berita->author->name
            ] : null,
            'published_at' => $berita->tanggal_publish ?: $berita->created_at->format('Y-m-d'),
            'read_time' => $this->estimateReadTime($berita->isi),
            'views' => rand(100, 5000), // Placeholder since views field doesn't exist
            'featured' => rand(0, 10) > 8, // Random featured for demo
            'updated_at' => $berita->updated_at->format('Y-m-d'),
        ];

        return response()->json([
            'success' => true,
            'article' => $article
        ]);
    }

    /**
     * Get popular tags for articles
     */
    public function articleTags()
    {
        // Since there's no tags table, we'll return some default tags
        $tags = [
            ['id' => 1, 'name' => 'Kesehatan', 'slug' => 'kesehatan', 'count' => 15],
            ['id' => 2, 'name' => 'Poli', 'slug' => 'poli', 'count' => 8],
            ['id' => 3, 'name' => 'Dokter', 'slug' => 'dokter', 'count' => 12],
            ['id' => 4, 'name' => 'Vaksinasi', 'slug' => 'vaksinasi', 'count' => 6],
            ['id' => 5, 'name' => 'Pandemi', 'slug' => 'pandemi', 'count' => 4],
            ['id' => 6, 'name' => 'Tips Kesehatan', 'slug' => 'tips-kesehatan', 'count' => 10],
            ['id' => 7, 'name' => 'Rawat Inap', 'slug' => 'rawat-inap', 'count' => 5],
            ['id' => 8, 'name' => 'IGD', 'slug' => 'igd', 'count' => 7]
        ];

        return response()->json([
            'success' => true,
            'tags' => $tags
        ]);
    }

    /**
     * Get comments for an article
     */
    public function articleComments($articleId)
    {
        // Since there's no comments table, we'll return mock data
        $comments = [
            [
                'id' => 1,
                'name' => 'Ahmad Susanto',
                'email' => 'ahmad@example.com',
                'comment' => 'Artikel yang sangat informatif dan bermanfaat. Terima kasih atas informasinya!',
                'created_at' => '2025-11-10T10:30:00Z',
                'article_id' => $articleId
            ],
            [
                'id' => 2,
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'comment' => 'Penjelasannya mudah dipahami, sangat membantu saya untuk memahami topik ini.',
                'created_at' => '2025-11-09T14:15:00Z',
                'article_id' => $articleId
            ],
            [
                'id' => 3,
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'comment' => 'Mohon informasi lebih lanjut mengenai jadwal pelayanan untuk topik ini.',
                'created_at' => '2025-11-08T09:45:00Z',
                'article_id' => $articleId
            ]
        ];

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    /**
     * Submit a comment for an article
     */
    public function submitArticleComment(Request $request, $articleId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000'
        ]);

        // In a real implementation, you would save this to a comments table
        // For now, we'll just return a success response

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim dan akan ditampilkan setelah moderasi.'
        ]);
    }

    /**
     * Estimate reading time based on content length
     */
    private function estimateReadTime($content)
    {
        if (empty($content)) {
            return '1 min';
        }

        $wordCount = str_word_count(strip_tags($content));
        $wordsPerMinute = 200; // Average reading speed
        $minutes = ceil($wordCount / $wordsPerMinute);

        return $minutes . ' min';
    }

    /**
     * Get doctors for public frontend
     */
    public function doctors(Request $request)
    {
        $query = Dokter::with(['poli', 'jadwals'])
            ->where('status', 'aktif');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('spesialis', 'like', '%' . $search . '%');
            });
        }

        // Specialization filter
        if ($request->has('specialization') && !empty($request->specialization)) {
            $query->where('spesialis', $request->specialization);
        }

        // Poli filter
        if ($request->has('poli') && !empty($request->poli)) {
            $query->whereHas('poli', function ($q) use ($request) {
                $q->where('nama_poli', 'like', '%' . $request->poli . '%');
            });
        }

        // Order by name
        $query->orderBy('nama', 'asc');

        // Get all doctors (no pagination for frontend)
        $doctors = $query->get();
        
        // Transform data to match frontend expectations
        $transformedDoctors = $doctors->map(function ($doctor) {
            // Get schedule information
            $schedules = $doctor->jadwals;
            $scheduleText = 'Tidak ada jadwal';
            $scheduleTime = '';
           
            
            // Filter out schedules where is_cuti = 1
            $activeSchedules = $schedules->filter(function ($schedule) {
                return $schedule->is_cuti != 1;
            });
            
            // Always process if there are schedules (active or on leave)
            if ($schedules->count() > 0) {
                // Format schedule with grouped consecutive days
                $scheduleText = $this->formatDoctorSchedule($activeSchedules);
                
                // Determine if doctor is available today
                $today = now()->format('l');
                $dayMap = [
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu'
                ];
                
                $todayIndonesian = $dayMap[$today] ?? '';
                $todaySchedule = $activeSchedules->where('hari', $todayIndonesian)->first();
                
                if ($todaySchedule) {
                    // Check if current time is within schedule
                    $currentTime = now()->format('H:i');
                    if ($currentTime >= $todaySchedule->jam_mulai && $currentTime <= $todaySchedule->jam_selesai) {
                        $available = true;
                    }
                }
                
                // Determine schedule time category
                $earliestTime = $activeSchedules->min('jam_mulai');
                if ($earliestTime && $earliestTime < '12:00') {
                    $scheduleTime = 'morning';
                } elseif ($earliestTime && $earliestTime < '17:00') {
                    $scheduleTime = 'afternoon';
                } else {
                    $scheduleTime = 'evening';
                }
            }

            return [
                'id' => $doctor->id,
                'name' => $doctor->nama,
                'specialization' => $doctor->spesialis,
                'image' => $doctor->foto ? asset('storage/' . $doctor->foto) : 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default.jpg',
                'schedule' => $scheduleText,
                'scheduleTime' => $scheduleTime,
                'available' => $activeSchedules->count() > 0,
                'profile_url' => "/medis/{$doctor->slug}",
                'poli' => $doctor->poli ? $doctor->poli->nama_poli : null,
                'kontak' => $doctor->kontak
            ];
        });

        return response()->json([
            'success' => true,
            'doctors' => $transformedDoctors->values()->all()
        ]);
    }
    
    /**
     * Format doctor's schedule by grouping consecutive days with identical hours
     */
    private function formatDoctorSchedule($schedules)
    {
        // Define day order for proper sorting
        $dayOrder = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7
        ];
        
        // Group schedules by time
        $timeGroups = [];
        foreach ($schedules as $schedule) {
            $timeKey = $schedule->jam_mulai . '-' . $schedule->jam_selesai;
            if (!isset($timeGroups[$timeKey])) {
                $timeGroups[$timeKey] = [];
            }
            $timeGroups[$timeKey][] = $schedule->hari;
        }
        
        // Sort days within each time group and format the output
        $formattedSchedule = [];
        foreach ($timeGroups as $timeKey => $days) {
            // Sort days according to the defined order
            usort($days, function ($a, $b) use ($dayOrder) {
                return $dayOrder[$a] - $dayOrder[$b];
            });
            
            // Group consecutive days
            $dayGroups = $this->groupConsecutiveDays($days);
            
            // Format each group
            foreach ($dayGroups as $group) {
                if (count($group) > 1) {
                    $formattedSchedule[] = $group[0] . ' - ' . end($group) . ' ' . str_replace('-', ' - ', $timeKey);
                } else {
                    $formattedSchedule[] = $group[0] . ' ' . str_replace('-', ' - ', $timeKey);
                }
            }
        }
        
        return implode(', ', $formattedSchedule);
    }
    
    /**
     * Group consecutive days in an array
     */
    private function groupConsecutiveDays($days)
    {
        $dayOrder = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7
        ];
        
        $groups = [];
        $currentGroup = [];
        
        foreach ($days as $day) {
            if (empty($currentGroup)) {
                $currentGroup[] = $day;
            } else {
                $lastDay = end($currentGroup);
                // Check if current day is consecutive to the last day
                if ($dayOrder[$day] == $dayOrder[$lastDay] + 1) {
                    $currentGroup[] = $day;
                } else {
                    // Save current group and start a new one
                    $groups[] = $currentGroup;
                    $currentGroup = [$day];
                }
            }
        }
        
        // Don't forget to add the last group
        if (!empty($currentGroup)) {
            $groups[] = $currentGroup;
        }
        
        return $groups;
    }

    /**
     * Get doctor specializations for filters
     */
    public function doctorSpecializations()
    {
        $specializations = Dokter::where('status', 'aktif')
            ->select('spesialis')
            ->distinct()
            ->orderBy('spesialis', 'asc')
            ->pluck('spesialis')
            ->filter();

        return response()->json([
            'success' => true,
            'specializations' => $specializations->prepend('Semua Spesialisasi')
        ]);
    }

    /**
     * Get polis for filters
     */
    public function polis()
    {
        $polis = Poli::where('status', 'aktif')
            ->orderBy('nama_poli', 'asc')
            ->get(['id', 'nama_poli']);

        return response()->json([
            'success' => true,
            'polis' => $polis->prepend(['id' => '', 'nama_poli' => 'Semua Poli'])
        ]);
    }

    /**
     * Get doctor schedules
     */
    public function doctorSchedules(Request $request)
    {
        $query = Jadwal_poli::with(['dokter', 'poli']);

        // Filter by doctor
        if ($request->has('doctor_id') && !empty($request->doctor_id)) {
            $query->where('dokter_id', $request->doctor_id);
        }

        // Filter by poli
        if ($request->has('poli_id') && !empty($request->poli_id)) {
            $query->where('poli_id', $request->poli_id);
        }

        // Filter by day
        if ($request->has('day') && !empty($request->day)) {
            $query->where('hari', $request->day);
        }

        // Order by day and time
        $schedules = $query->orderBy('hari', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Transform data
        $transformedSchedules = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'date' => $schedule->hari,
                'event' => $schedule->dokter->nama . ' - ' . $schedule->poli->nama_poli,
                'location' => $schedule->poli->ruangan ?? $schedule->poli->nama_poli,
                'time' => $schedule->jam_mulai . ' - ' . $schedule->jam_selesai,
                'doctor' => [
                    'id' => $schedule->dokter->id,
                    'name' => $schedule->dokter->nama,
                    'specialization' => $schedule->dokter->spesialis
                ],
                'poli' => [
                    'id' => $schedule->poli->id,
                    'name' => $schedule->poli->nama_poli
                ],
                'is_cuti' => $schedule->is_cuti,
                'keterangan' => $schedule->keterangan
            ];
        });

        return response()->json([
            'success' => true,
            'schedules' => $transformedSchedules
        ]);
    }

    /**
     * Get single doctor by slug
     */
    public function doctor($slug)
    {
        $doctor = Dokter::with(['poli', 'jadwals'])
            ->where('slug', $slug)
            ->where('status', 'aktif')
            ->first();

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan'
            ], 404);
        }

        // Filter out schedules where is_cuti = 1
        $activeSchedules = $doctor->jadwals->filter(function ($schedule) {
            return $schedule->is_cuti != 1;
        });

        // Get schedule information
        $schedules = $activeSchedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'day' => $schedule->hari,
                'time' => $schedule->jam_mulai . ' - ' . $schedule->jam_selesai,
                'poli' => $schedule->poli->nama_poli,
                'room' => $schedule->poli->ruangan,
                'is_cuti' => $schedule->is_cuti,
                'keterangan' => $schedule->keterangan
            ];
        });

        // Format schedule for display
        $formattedSchedule = 'Tidak ada jadwal';
        if ($activeSchedules->count() > 0) {
            $formattedSchedule = $this->formatDoctorSchedule($activeSchedules);
        }

        $doctorData = [
            'id' => $doctor->id,
            'slug' => $doctor->slug,
            'name' => $doctor->nama,
            'specialization' => $doctor->spesialis,
            'image' => $doctor->foto ? asset('storage/' . $doctor->foto) : 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default.jpg',
            'schedule' => $formattedSchedule,
            'kontak' => $doctor->kontak,
            'poli' => $doctor->poli ? [
                'id' => $doctor->poli->id,
                'name' => $doctor->poli->nama_poli,
                'room' => $doctor->poli->ruangan,
                'description' => $doctor->poli->deskripsi
            ] : null,
            'schedules' => $schedules
        ];

        return response()->json([
            'success' => true,
            'doctor' => $doctorData
        ]);
    }
}
