<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected AnalyticsService $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    
    public function __invoke(Request $request)
    {
        $metrics = $this->analyticsService->getOverviewMetrics();
        $trends = $this->analyticsService->getTrendsData(30);
        $monthlyTrend = $this->analyticsService->getMonthlyPublishingTrend();
        $categoriesDist = $this->analyticsService->getCategoryDistribution();
        $recentActivities = $this->analyticsService->getRecentActivity(5);

        return Inertia::render('Admin/Dashboard', [
            'metrics' => $metrics,
            'trends' => $trends,
            'monthlyTrend' => $monthlyTrend,
            'categoriesDist' => $categoriesDist,
            'recentActivities' => $recentActivities,
        ]);
    }
}
