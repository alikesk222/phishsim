@extends('layouts.app')

@section('title', isset($employee) ? 'Edit Employee' : 'Add Employee')

@section('content')
<div class="mb-6">
  <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-white text-sm">← Employees</a>
  <h1 class="text-2xl font-bold mt-2">{{ isset($employee) ? 'Edit Employee' : 'Add Employee' }}</h1>
</div>

<form method="POST"
  action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}"
  class="space-y-6 max-w-lg">
  @csrf
  @if(isset($employee))
    @method('PUT')
  @endif

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-400 mb-1">First Name <span class="text-red-500">*</span></label>
        <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 @error('first_name') border-red-500 @enderror">
        @error('first_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Last Name <span class="text-red-500">*</span></label>
        <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" required
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 @error('last_name') border-red-500 @enderror">
        @error('last_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
    </div>

    <div>
      <label class="block text-sm text-gray-400 mb-1">Email <span class="text-red-500">*</span></label>
      <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required
        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 @error('email') border-red-500 @enderror">
      @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-400 mb-1">Department</label>
        <input type="text" name="department" value="{{ old('department', $employee->department ?? '') }}"
          placeholder="Engineering"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Position</label>
        <input type="text" name="position" value="{{ old('position', $employee->position ?? '') }}"
          placeholder="Software Engineer"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
      </div>
    </div>

    <div>
      <label class="block text-sm text-gray-400 mb-1">Phone</label>
      <input type="text" name="phone" value="{{ old('phone', $employee->phone ?? '') }}"
        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
    </div>

    <div class="flex items-center gap-2">
      <input type="checkbox" name="is_active" id="is_active" value="1"
        {{ old('is_active', $employee->is_active ?? true) ? 'checked' : '' }}
        class="accent-red-500">
      <label for="is_active" class="text-sm text-gray-400">Active (include in campaigns)</label>
    </div>
  </div>

  <div class="flex gap-3">
    <button type="submit"
      class="bg-red-600 hover:bg-red-500 text-white font-medium px-6 py-2 rounded-lg text-sm transition-colors">
      {{ isset($employee) ? 'Save Changes' : 'Add Employee' }}
    </button>
    <a href="{{ route('employees.index') }}" class="text-gray-400 hover:text-white text-sm px-4 py-2">Cancel</a>
  </div>
</form>
@endsection
