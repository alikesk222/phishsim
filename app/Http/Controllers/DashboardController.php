<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $org = Auth::user()->organization;

        $campaigns   = $org->campaigns()->with('targets')->latest()->take(5)->get();
        $employees   = $org->employees();
        $riskCounts  = [
            'critical' => (clone $employees)->where('risk_level', 'critical')->count(),
            'high'     => (clone $employees)->where('risk_level', 'high')->count(),
            'medium'   => (clone $employees)->where('risk_level', 'medium')->count(),
            'low'      => (clone $employees)->where('risk_level', 'low')->count(),
        ];

        $stats = [
            'employees'     => (clone $employees)->where('active', true)->count(),
            'campaigns'     => $org->campaigns()->count(),
            'running'       => $org->campaigns()->where('status', 'running')->count(),
            'phished_total' => $org->employees()->sum('phished_count'),
        ];

        // Overall click rate across all campaigns
        $allTargets = \App\Models\CampaignTarget::whereHas('campaign', fn($q) => $q->where('organization_id', $org->id))->get();
        $stats['click_rate'] = $allTargets->count() > 0
            ? round($allTargets->whereNotNull('clicked_at')->count() / $allTargets->count() * 100, 1)
            : 0;

        return view('dashboard.index', compact('campaigns', 'riskCounts', 'stats'));
    }
}
