@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-bold">Dashboard</h1>
  <p class="text-gray-500 text-sm mt-1">Security awareness overview for {{ auth()->user()->organization->name }}</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 mb-8">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Active Employees</p>
    <p class="text-3xl font-bold text-white">{{ $stats['employees'] }}</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Campaigns</p>
    <p class="text-3xl font-bold text-white">{{ $stats['campaigns'] }}</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Phished</p>
    <p class="text-3xl font-bold text-red-400">{{ $stats['phished_total'] }}</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Avg Click Rate</p>
    <p class="text-3xl font-bold text-yellow-400">{{ $stats['click_rate'] }}%</p>
  </div>
</div>

<div class="grid grid-cols-2 gap-6">
  {{-- Recent Campaigns --}}
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-semibold">Recent Campaigns</h2>
      <a href="{{ route('campaigns.index') }}" class="text-xs text-red-400 hover:text-red-300">View all</a>
    </div>
    @forelse($campaigns as $campaign)
      <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
        <div>
          <a href="{{ route('campaigns.show', $campaign) }}" class="text-sm font-medium hover:text-red-400">{{ $campaign->name }}</a>
          <p class="text-xs text-gray-500">{{ $campaign->created_at->diffForHumans() }}</p>
        </div>
        <span class="text-xs px-2 py-1 rounded-full
          {{ $campaign->status === 'completed' ? 'bg-green-900/40 text-green-400' : '' }}
          {{ $campaign->status === 'running' ? 'bg-blue-900/40 text-blue-400' : '' }}
          {{ $campaign->status === 'draft' ? 'bg-gray-800 text-gray-400' : '' }}
          {{ $campaign->status === 'scheduled' ? 'bg-yellow-900/40 text-yellow-400' : '' }}
        ">{{ ucfirst($campaign->status) }}</span>
      </div>
    @empty
      <p class="text-sm text-gray-500">No campaigns yet. <a href="{{ route('campaigns.create') }}" class="text-red-400 hover:text-red-300">Create one</a></p>
    @endforelse
  </div>

  {{-- Risk Distribution --}}
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-semibold">Employee Risk Distribution</h2>
      <a href="{{ route('employees.index') }}" class="text-xs text-red-400 hover:text-red-300">View all</a>
    </div>
    <div class="space-y-3">
      @php $total = array_sum($riskCounts) ?: 1; @endphp
      <div class="flex items-center gap-3">
        <span class="text-xs text-red-400 w-14">Critical</span>
        <div class="flex-1 bg-gray-800 rounded-full h-2">
          <div class="bg-red-500 h-2 rounded-full" style="width: {{ round($riskCounts['critical'] / $total * 100) }}%"></div>
        </div>
        <span class="text-xs text-gray-400 w-6 text-right">{{ $riskCounts['critical'] }}</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-xs text-orange-400 w-14">High</span>
        <div class="flex-1 bg-gray-800 rounded-full h-2">
          <div class="bg-orange-500 h-2 rounded-full" style="width: {{ round($riskCounts['high'] / $total * 100) }}%"></div>
        </div>
        <span class="text-xs text-gray-400 w-6 text-right">{{ $riskCounts['high'] }}</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-xs text-yellow-400 w-14">Medium</span>
        <div class="flex-1 bg-gray-800 rounded-full h-2">
          <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ round($riskCounts['medium'] / $total * 100) }}%"></div>
        </div>
        <span class="text-xs text-gray-400 w-6 text-right">{{ $riskCounts['medium'] }}</span>
      </div>
      <div class="flex items-center gap-3">
        <span class="text-xs text-green-400 w-14">Low</span>
        <div class="flex-1 bg-gray-800 rounded-full h-2">
          <div class="bg-green-500 h-2 rounded-full" style="width: {{ round($riskCounts['low'] / $total * 100) }}%"></div>
        </div>
        <span class="text-xs text-gray-400 w-6 text-right">{{ $riskCounts['low'] }}</span>
      </div>
    </div>
    @if($stats['running'] > 0)
      <div class="mt-4 pt-4 border-t border-gray-800">
        <p class="text-sm text-blue-400">{{ $stats['running'] }} campaign{{ $stats['running'] > 1 ? 's' : '' }} currently running</p>
      </div>
    @endif
  </div>
</div>
@endsection
