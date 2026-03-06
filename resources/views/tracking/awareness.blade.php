<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PhishSim</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-950 text-gray-100 flex items-center justify-center px-4 py-12">

<div class="max-w-lg w-full">
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-900/40 border border-yellow-700 mb-4">
      <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
      </svg>
    </div>
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">{{ __('tracking.awareness_title') }}</h1>
    <p class="text-gray-400">{{ __('tracking.awareness_subtitle') }}</p>
  </div>

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
    <h2 class="font-semibold mb-3">{{ __('tracking.what_happened') }}</h2>
    <p class="text-sm text-gray-400 mb-4">{{ __('tracking.what_happened_desc') }}</p>

    <h2 class="font-semibold mb-3">{{ __('tracking.how_to_spot') }}</h2>
    <ul class="space-y-2 text-sm text-gray-400">
      <li class="flex items-start gap-2">
        <span class="text-yellow-400 mt-0.5">•</span>
        <span><strong class="text-white">{{ __('tracking.tip_sender') }}</strong> — {{ __('tracking.tip_sender_desc') }}</span>
      </li>
      <li class="flex items-start gap-2">
        <span class="text-yellow-400 mt-0.5">•</span>
        <span><strong class="text-white">{{ __('tracking.tip_hover') }}</strong> — {{ __('tracking.tip_hover_desc') }}</span>
      </li>
      <li class="flex items-start gap-2">
        <span class="text-yellow-400 mt-0.5">•</span>
        <span><strong class="text-white">{{ __('tracking.tip_urgency') }}</strong> — {{ __('tracking.tip_urgency_desc') }}</span>
      </li>
      <li class="flex items-start gap-2">
        <span class="text-yellow-400 mt-0.5">•</span>
        <span><strong class="text-white">{{ __('tracking.tip_credentials') }}</strong> — {{ __('tracking.tip_credentials_desc') }}</span>
      </li>
      <li class="flex items-start gap-2">
        <span class="text-yellow-400 mt-0.5">•</span>
        <span><strong class="text-white">{{ __('tracking.tip_report') }}</strong> — {{ __('tracking.tip_report_desc') }}</span>
      </li>
    </ul>
  </div>

  <div class="bg-blue-900/20 border border-blue-800 rounded-xl p-4 text-sm text-blue-300">
    <strong>{{ __('tracking.awareness_next') }}:</strong> {{ __('tracking.awareness_next_desc') }}
  </div>
</div>

</body>
</html>
