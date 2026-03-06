@extends('layouts.app')

@section('title', $campaign->name)

@section('content')
<div class="mb-6">
  <a href="{{ route('campaigns.index') }}" class="text-gray-500 hover:text-white text-sm">← Campaigns</a>
  <div class="flex items-start justify-between mt-2">
    <div>
      <h1 class="text-2xl font-bold">{{ $campaign->name }}</h1>
      @if($campaign->description)
        <p class="text-gray-500 text-sm mt-1">{{ $campaign->description }}</p>
      @endif
    </div>
    <div class="flex items-center gap-3">
      <span class="text-xs px-2 py-1 rounded-full
        {{ $campaign->status === 'completed' ? 'bg-green-900/40 text-green-400' : '' }}
        {{ $campaign->status === 'running' ? 'bg-blue-900/40 text-blue-400' : '' }}
        {{ $campaign->status === 'draft' ? 'bg-gray-800 text-gray-400' : '' }}
        {{ $campaign->status === 'scheduled' ? 'bg-yellow-900/40 text-yellow-400' : '' }}
      ">{{ ucfirst($campaign->status) }}</span>

      @if($campaign->isEditable())
        <form method="POST" action="{{ route('campaigns.launch', $campaign) }}">
          @csrf
          <button type="submit"
            class="bg-red-600 hover:bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors"
            onclick="return confirm('Launch this campaign? Phishing emails will be sent immediately.')">
            Launch Now
          </button>
        </form>
      @endif
    </div>
  </div>
</div>

{{-- Stats --}}
@php $stats = $campaign->stats; @endphp
<div class="grid grid-cols-4 gap-4 mb-6">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Targets</p>
    <p class="text-3xl font-bold">{{ $campaign->targets()->count() }}</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Open Rate</p>
    <p class="text-3xl font-bold text-blue-400">{{ $stats['open_rate'] }}%</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Click Rate</p>
    <p class="text-3xl font-bold {{ $stats['click_rate'] > 30 ? 'text-red-400' : ($stats['click_rate'] > 10 ? 'text-yellow-400' : 'text-green-400') }}">
      {{ $stats['click_rate'] }}%
    </p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Submit Rate</p>
    <p class="text-3xl font-bold {{ $stats['submit_rate'] > 0 ? 'text-red-400' : 'text-green-400' }}">
      {{ $stats['submit_rate'] }}%
    </p>
  </div>
</div>

{{-- Targets Table --}}
<div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-800">
    <h2 class="font-semibold">Target Results</h2>
  </div>
  <table class="w-full text-sm">
    <thead>
      <tr class="border-b border-gray-800 text-gray-500 text-xs uppercase tracking-wide">
        <th class="text-left px-5 py-3">Employee</th>
        <th class="text-left px-5 py-3">Status</th>
        <th class="text-left px-5 py-3">Opened</th>
        <th class="text-left px-5 py-3">Clicked</th>
        <th class="text-left px-5 py-3">Submitted</th>
        <th class="text-left px-5 py-3">Reported</th>
        <th class="text-left px-5 py-3">Sent At</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-800">
      @foreach($targets as $target)
        <tr class="hover:bg-gray-800/50">
          <td class="px-5 py-3">
            <p class="font-medium">{{ $target->employee->full_name }}</p>
            <p class="text-xs text-gray-500">{{ $target->employee->email }}</p>
          </td>
          <td class="px-5 py-3">
            <span class="text-xs px-2 py-1 rounded-full
              {{ $target->status === 'sent' ? 'bg-gray-800 text-gray-400' : '' }}
              {{ $target->status === 'opened' ? 'bg-blue-900/40 text-blue-400' : '' }}
              {{ $target->status === 'clicked' ? 'bg-yellow-900/40 text-yellow-400' : '' }}
              {{ $target->status === 'submitted' ? 'bg-red-900/40 text-red-400' : '' }}
              {{ $target->status === 'reported' ? 'bg-green-900/40 text-green-400' : '' }}
              {{ $target->status === 'pending' ? 'bg-gray-900 text-gray-600 border border-gray-700' : '' }}
            ">{{ ucfirst($target->status) }}</span>
          </td>
          <td class="px-5 py-3 text-gray-400 text-xs">{{ $target->opened_at ? $target->opened_at->format('M j H:i') : '—' }}</td>
          <td class="px-5 py-3 text-gray-400 text-xs">{{ $target->clicked_at ? $target->clicked_at->format('M j H:i') : '—' }}</td>
          <td class="px-5 py-3 text-gray-400 text-xs">{{ $target->submitted_at ? $target->submitted_at->format('M j H:i') : '—' }}</td>
          <td class="px-5 py-3 text-gray-400 text-xs">{{ $target->reported_at ? $target->reported_at->format('M j H:i') : '—' }}</td>
          <td class="px-5 py-3 text-gray-500 text-xs">{{ $target->sent_at ? $target->sent_at->format('M j H:i') : '—' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@if($campaign->isEditable())
  <div class="mt-6 pt-6 border-t border-gray-800 flex items-center gap-3">
    <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-xs text-red-500 hover:text-red-400"
        onclick="return confirm('Delete this campaign?')">Delete Campaign</button>
    </form>
  </div>
@endif
@endsection
