<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In — PhishSim</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { theme: { extend: { colors: { gray: { 950: '#0a0f1a' } } } } }</script>
</head>
<body class="h-full text-gray-100 flex items-center justify-center">

<div class="w-full max-w-sm px-4">
  <div class="text-center mb-8">
    <span class="text-red-500 font-bold text-2xl tracking-wide">Phish</span><span class="text-white font-bold text-2xl">Sim</span>
    <p class="text-gray-500 text-sm mt-1">Phishing Awareness Training Platform</p>
  </div>

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-8">
    <h1 class="text-lg font-semibold mb-6">Sign in to your account</h1>

    @if($errors->any())
      <div class="mb-4 px-4 py-3 bg-red-900/40 border border-red-700 text-red-300 rounded-lg text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm text-gray-400 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Password</label>
        <input type="password" name="password" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div class="flex items-center gap-2">
        <input type="checkbox" name="remember" id="remember" class="accent-red-500">
        <label for="remember" class="text-sm text-gray-400">Remember me</label>
      </div>
      <button type="submit"
        class="w-full bg-red-600 hover:bg-red-500 text-white font-medium py-2 rounded-lg text-sm transition-colors">
        Sign In
      </button>
    </form>
  </div>

  <p class="text-center text-sm text-gray-500 mt-4">
    Don't have an account?
    <a href="{{ route('register') }}" class="text-red-400 hover:text-red-300">Create one</a>
  </p>
</div>

</body>
</html>
