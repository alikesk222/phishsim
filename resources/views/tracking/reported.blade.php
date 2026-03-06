<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PhishSim</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-950 text-gray-100 flex items-center justify-center px-4">

<div class="max-w-md w-full text-center">
  <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-900/40 border border-green-700 mb-6">
    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
  </div>

  <h1 class="text-2xl font-bold text-green-400 mb-2">{{ __('tracking.reported_title') }}</h1>
  <p class="text-gray-400 mb-6">{{ __('tracking.reported_subtitle') }}</p>

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-left text-sm text-gray-400">
    <p class="font-semibold text-white mb-2">{{ __('tracking.reported_was_test') }}</p>
    <p>{{ __('tracking.reported_desc') }}</p>
    <p class="mt-3">{{ __('tracking.reported_keep_up') }}</p>
  </div>
</div>

</body>
</html>
