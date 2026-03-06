<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account — PhishSim</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { theme: { extend: { colors: { gray: { 950: '#0a0f1a' } } } } }</script>
</head>
<body class="h-full text-gray-100 flex items-center justify-center py-12">

<div class="w-full max-w-sm px-4">
  <div class="text-center mb-8">
    <span class="text-red-500 font-bold text-2xl tracking-wide">Phish</span><span class="text-white font-bold text-2xl">Sim</span>
    <p class="text-gray-500 text-sm mt-1">Phishing Awareness Training Platform</p>
  </div>

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-8">
    <h1 class="text-lg font-semibold mb-6">Create your organization</h1>

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
        <label class="block text-sm text-gray-400 mb-1">Organization Name</label>
        <input type="text" name="organization_name" value="{{ old('organization_name') }}" required autofocus
          placeholder="Acme Corp"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Your Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required
          placeholder="Jane Smith"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Password</label>
        <input type="password" name="password" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <button type="submit"
        class="w-full bg-red-600 hover:bg-red-500 text-white font-medium py-2 rounded-lg text-sm transition-colors">
        Create Account
      </button>
    </form>
  </div>

  <p class="text-center text-sm text-gray-500 mt-4">
    Already have an account?
    <a href="{{ route('login') }}" class="text-red-400 hover:text-red-300">Sign in</a>
  </p>
</div>

</body>
</html>
