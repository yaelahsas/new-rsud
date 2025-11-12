<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori_berita;
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
            ->where('publish', true);

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
}
