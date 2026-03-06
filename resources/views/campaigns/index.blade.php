@extends('layouts.app')

@section('title', __('campaigns.title'))

@section('content')
<div class="flex items-center justify-between mb-6">
  <div>
    <h1 class="text-2xl font-bold">{{ __('campaigns.title') }}</h1>
    <p class="text-gray-500 text-sm mt-1">{{ __('campaigns.subtitle') }}</p>
  </div>
  <a href="{{ route('campaigns.create') }}"
    class="bg-red-600 hover:bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
    {{ __('campaigns.new_campaign') }}
  </a>
</div>

@if($campaigns->isEmpty())
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-12 text-center">
    <svg class="w-12 h-12 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
    </svg>
    <p class="text-gray-400 font-medium mb-1">{{ __('campaigns.no_campaigns') }}</p>
    <p class="text-gray-600 text-sm mb-4">{{ __('campaigns.no_campaigns_desc') }}</p>
    <a href="{{ route('campaigns.create') }}" class="bg-red-600 hover:bg-red-500 text-white text-sm px-4 py-2 rounded-lg transition-colors">
      {{ __('campaigns.create_campaign') }}
    </a>
  </div>
@else
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800 text-gray-500 text-xs uppercase tracking-wide">
          <th class="text-left px-5 py-3">{{ __('campaigns.campaign') }}</th>
          <th class="text-left px-5 py-3">{{ __('campaigns.status') }}</th>
          <th class="text-left px-5 py-3">{{ __('campaigns.targets') }}</th>
          <th class="text-left px-5 py-3">{{ __('campaigns.open_rate') }}</th>
          <th class="text-left px-5 py-3">{{ __('campaigns.click_rate') }}</th>
          <th class="text-left px-5 py-3">{{ __('campaigns.created') }}</th>
          <th class="px-5 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        @foreach($campaigns as $campaign)
          @php $stats = $campaign->stats; @endphp
          <tr class="hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-4">
              <a href="{{ route('campaigns.show', $campaign) }}" class="font-medium hover:text-red-400">{{ $campaign->name }}</a>
              @if($campaign->description)
                <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($campaign->description, 60) }}</p>
              @endif
            </td>
            <td class="px-5 py-4">
              <span class="text-xs px-2 py-1 rounded-full
                {{ $campaign->status === 'completed' ? 'bg-green-900/40 text-green-400' : '' }}
                {{ $campaign->status === 'running' ? 'bg-blue-900/40 text-blue-400' : '' }}
                {{ $campaign->status === 'draft' ? 'bg-gray-800 text-gray-400' : '' }}
                {{ $campaign->status === 'scheduled' ? 'bg-yellow-900/40 text-yellow-400' : '' }}
              ">{{ __('common.' . $campaign->status) }}</span>
            </td>
            <td class="px-5 py-4 text-gray-300">{{ $campaign->targets()->count() }}</td>
            <td class="px-5 py-4 text-gray-300">{{ $stats['open_rate'] }}%</td>
            <td class="px-5 py-4">
              <span class="{{ $stats['click_rate'] > 30 ? 'text-red-400' : ($stats['click_rate'] > 10 ? 'text-yellow-400' : 'text-green-400') }}">
                {{ $stats['click_rate'] }}%
              </span>
            </td>
            <td class="px-5 py-4 text-gray-500 text-xs">{{ $campaign->created_at->format('M j, Y') }}</td>
            <td class="px-5 py-4 text-right">
              <a href="{{ route('campaigns.show', $campaign) }}" class="text-gray-500 hover:text-white text-xs">{{ __('common.view') }}</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $campaigns->links() }}
  </div>
@endif
@endsection
