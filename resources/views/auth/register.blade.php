<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-gray-950">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('auth.create_account') }} — PhishSim</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { theme: { extend: { colors: { gray: { 950: '#0a0f1a' } } } } }</script>
</head>
<body class="h-full text-gray-100 flex items-center justify-center py-12">

<div class="w-full max-w-sm px-4">
  <div class="text-center mb-6">
    <span class="text-red-500 font-bold text-2xl tracking-wide">Phish</span><span class="text-white font-bold text-2xl">Sim</span>
    <p class="text-gray-500 text-sm mt-1">{{ __('auth.tagline') }}</p>
  </div>

  {{-- Language switcher --}}
  <div class="flex justify-center gap-1 mb-4">
    <a href="{{ route('lang.switch', 'en') }}"
      class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-gray-700 text-white' : 'text-gray-600 hover:text-white' }}">EN</a>
    <span class="text-gray-700 text-xs self-center">|</span>
    <a href="{{ route('lang.switch', 'tr') }}"
      class="text-xs px-2 py-1 rounded {{ app()->getLocale() === 'tr' ? 'bg-gray-700 text-white' : 'text-gray-600 hover:text-white' }}">TR</a>
  </div>

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-8">
    <h1 class="text-lg font-semibold mb-6">{{ __('auth.create_org') }}</h1>

    @if($errors->any())
      <div class="mb-4 px-4 py-3 bg-red-900/40 border border-red-700 text-red-300 rounded-lg text-sm">
        <ul class="space-y-1">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm text-gray-400 mb-1">{{ __('auth.org_name') }} <span class="text-red-500">*</span></label>
        <input type="text" name="organization_name" value="{{ old('organization_name') }}" required autofocus
          placeholder="{{ __('auth.org_placeholder') }}"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">{{ __('auth.your_name') }} <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required
          placeholder="{{ __('auth.name_placeholder') }}"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">{{ __('auth.email') }} <span class="text-red-500">*</span></label>
        <input type="email" name="email" value="{{ old('email') }}" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">{{ __('auth.password') }} <span class="text-red-500">*</span></label>
        <input type="password" name="password" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">{{ __('auth.confirm_password') }} <span class="text-red-500">*</span></label>
        <input type="password" name="password_confirmation" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <button type="submit"
        class="w-full bg-red-600 hover:bg-red-500 text-white font-medium py-2 rounded-lg text-sm transition-colors">
        {{ __('auth.create_account') }}
      </button>
    </form>
  </div>

  <p class="text-center text-sm text-gray-500 mt-4">
    {{ __('auth.have_account') }}
    <a href="{{ route('login') }}" class="text-red-400 hover:text-red-300">{{ __('auth.sign_in_link') }}</a>
  </p>
</div>

</body>
</html>
