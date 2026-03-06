<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-gray-950">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PhishSim') — PhishSim</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { theme: { extend: { colors: { gray: { 950: '#0a0f1a' } } } } }</script>
</head>
<body class="h-full text-gray-100">

<div class="flex h-full">
  {{-- Sidebar --}}
  <aside class="w-56 bg-gray-900 border-r border-gray-800 flex flex-col">
    <div class="px-5 py-4 border-b border-gray-800">
      <span class="text-red-500 font-bold text-lg tracking-wide">Phish</span><span class="text-white font-bold text-lg">Sim</span>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
        {{ __('common.dashboard') }}
      </a>
      <a href="{{ route('campaigns.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('campaigns.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        {{ __('common.campaigns') }}
      </a>
      <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('employees.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        {{ __('common.employees') }}
      </a>
    </nav>

    <div class="px-3 py-4 border-t border-gray-800 space-y-3">
      {{-- Language switcher --}}
      <div class="flex items-center gap-1">
        <a href="{{ route('lang.switch', 'en') }}"
          class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-gray-700 text-white' : 'text-gray-500 hover:text-white' }}">EN</a>
        <span class="text-gray-700 text-xs">|</span>
        <a href="{{ route('lang.switch', 'tr') }}"
          class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'tr' ? 'bg-gray-700 text-white' : 'text-gray-500 hover:text-white' }}">TR</a>
      </div>

      <p class="text-xs text-gray-500">{{ auth()->user()->organization->name }}</p>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-xs text-gray-400 hover:text-red-400">{{ __('common.sign_out') }}</button>
      </form>
    </div>
  </aside>

  {{-- Main --}}
  <main class="flex-1 overflow-auto">
    <div class="px-8 py-6">
      @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-900/40 border border-green-700 text-green-300 rounded-lg text-sm">
          {{ session('success') }}
        </div>
      @endif
      @yield('content')
    </div>
  </main>
</div>

</body>
</html>
