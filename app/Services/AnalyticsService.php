<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\VisitorLog;
use App\Models\PageView;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsService
{
    
    public function getOverviewMetrics(): array
    {
        $totalPosts = Post::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        
        $totalAuthors = User::role('author')->count();

        $totalVisitors = VisitorLog::distinct('ip_address')->count();
        $totalViews = PageView::count();

        
        $popularPosts = Post::with(['category', 'author'])
            ->withCount('pageViews')
            ->orderBy('page_views_count', 'desc')
            ->limit(5)
            ->get();

        
        $recentPosts = Post::with(['category', 'author'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'total_posts' => $totalPosts,
            'total_categories' => $totalCategories,
            'total_users' => $totalUsers,
            'total_authors' => $totalAuthors,
            'total_visitors' => $totalVisitors,
            'total_views' => $totalViews,
            'popular_posts' => $popularPosts,
            'recent_posts' => $recentPosts,
        ];
    }

    
    public function getTrendsData(int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();

        
        $visitors = VisitorLog::select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(DISTINCT ip_address) as count'))
            ->where('visited_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        
        $views = PageView::select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('viewed_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        
        $labels = [];
        $visitorData = [];
        $viewData = [];

        for ($i = $days; $i >= 0; $i--) {
            $dateStr = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($dateStr)->format('d M');
            $visitorData[] = $visitors[$dateStr] ?? 0;
            $viewData[] = $views[$dateStr] ?? 0;
        }

        return [
            'labels' => $labels,
            'visitors' => $visitorData,
            'views' => $viewData,
        ];
    }

    
    public function getMonthlyPublishingTrend(): array
    {
        $currentYear = Carbon::now()->year;

        $posts = Post::select(DB::raw('MONTH(published_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('published_at', $currentYear)
            ->where('status', 'published')
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = [];

        for ($m = 1; $m <= 12; $m++) {
            $data[] = $posts[$m] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    
    public function getCategoryDistribution(): array
    {
        return Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'count' => $cat->posts_count,
                ];
            })
            ->toArray();
    }

    
    public function getRecentActivity(int $limit = 10): array
    {
        return ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
