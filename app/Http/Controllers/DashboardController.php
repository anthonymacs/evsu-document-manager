<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Stat cards
        $totalDocuments = Document::count();

        $statusCounts = Document::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $submitted = $statusCounts['submitted'] ?? 0;
        $reviewed  = $statusCounts['reviewed']  ?? 0;
        $approved  = $statusCounts['approved']  ?? 0;
        $rejected  = $statusCounts['rejected']  ?? 0;

        // Category counts for stat cards and bar chart
        $categoryStats = Category::withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->get();

        // Recent submissions table
        $recentSubmissions = Document::with('category')
            ->latest()
            ->take(7)
            ->get();

        return view('dashboard.index', compact(
            'totalDocuments',
            'submitted',
            'reviewed',
            'approved',
            'rejected',
            'categoryStats',
            'recentSubmissions',
        ));
    }
}