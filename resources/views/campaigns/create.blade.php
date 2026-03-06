@extends('layouts.app')

@section('title', 'New Campaign')

@section('content')
<div class="mb-6">
  <a href="{{ route('campaigns.index') }}" class="text-gray-500 hover:text-white text-sm">← Campaigns</a>
  <h1 class="text-2xl font-bold mt-2">New Campaign</h1>
</div>

<form method="POST" action="{{ route('campaigns.store') }}" class="space-y-6 max-w-2xl">
  @csrf

  {{-- Basic Info --}}
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
    <h2 class="font-semibold text-sm text-gray-400 uppercase tracking-wide">Campaign Details</h2>

    <div>
      <label class="block text-sm text-gray-400 mb-1">Campaign Name <span class="text-red-500">*</span></label>
      <input type="text" name="name" value="{{ old('name') }}" required
        placeholder="Q1 Password Reset Simulation"
        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 @error('name') border-red-500 @enderror">
      @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
      <label class="block text-sm text-gray-400 mb-1">Description</label>
      <textarea name="description" rows="2"
        placeholder="Optional notes about this campaign"
        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 resize-none">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-400 mb-1">Scheduled At</label>
        <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
        <p class="text-xs text-gray-600 mt-1">Leave blank to save as draft</p>
      </div>
      <div>
        <label class="block text-sm text-gray-400 mb-1">Send Delay (seconds)</label>
        <input type="number" name="send_delay_seconds" value="{{ old('send_delay_seconds', 0) }}" min="0"
          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
        <p class="text-xs text-gray-600 mt-1">Delay between each email</p>
      </div>
    </div>
  </div>

  {{-- Template --}}
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
    <h2 class="font-semibold text-sm text-gray-400 uppercase tracking-wide">Phishing Template</h2>

    @if($templates->isEmpty())
      <p class="text-sm text-gray-500">No templates available.</p>
    @else
      <div class="grid grid-cols-1 gap-2">
        @foreach($templates as $template)
          <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-700 hover:border-gray-600 cursor-pointer has-[:checked]:border-red-500 has-[:checked]:bg-red-950/20">
            <input type="radio" name="phishing_template_id" value="{{ $template->id }}"
              {{ old('phishing_template_id') == $template->id ? 'checked' : '' }}
              class="mt-0.5 accent-red-500">
            <div>
              <p class="text-sm font-medium">{{ $template->name }}</p>
              <p class="text-xs text-gray-500 mt-0.5">{{ $template->subject }}</p>
              @if($template->category)
                <span class="text-xs text-gray-600">{{ $template->category }}</span>
              @endif
            </div>
          </label>
        @endforeach
      </div>
      @error('phishing_template_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    @endif
  </div>

  {{-- Targets --}}
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
    <h2 class="font-semibold text-sm text-gray-400 uppercase tracking-wide">Target Employees</h2>

    @if($employees->isEmpty())
      <p class="text-sm text-gray-500">No employees yet. <a href="{{ route('employees.create') }}" class="text-red-400 hover:text-red-300">Add employees first</a>.</p>
    @else
      <div class="flex items-center gap-3 mb-2">
        <button type="button" id="selectAll" class="text-xs text-red-400 hover:text-red-300">Select All</button>
        <button type="button" id="deselectAll" class="text-xs text-gray-500 hover:text-white">Deselect All</button>
        <span class="text-xs text-gray-600" id="selectedCount">0 selected</span>
      </div>

      <div class="max-h-64 overflow-y-auto space-y-1 pr-1" id="employeeList">
        @foreach($employees as $employee)
          <label class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 cursor-pointer">
            <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}"
              class="employee-checkbox accent-red-500"
              {{ in_array($employee->id, old('employee_ids', [])) ? 'checked' : '' }}>
            <div class="flex-1 min-w-0">
              <span class="text-sm">{{ $employee->full_name }}</span>
              <span class="text-gray-500 text-xs ml-2">{{ $employee->email }}</span>
            </div>
            @if($employee->department)
              <span class="text-xs text-gray-600">{{ $employee->department }}</span>
            @endif
          </label>
        @endforeach
      </div>
      @error('employee_ids')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    @endif
  </div>

  <div class="flex gap-3">
    <button type="submit"
      class="bg-red-600 hover:bg-red-500 text-white font-medium px-6 py-2 rounded-lg text-sm transition-colors">
      Save Campaign
    </button>
    <a href="{{ route('campaigns.index') }}" class="text-gray-400 hover:text-white text-sm px-4 py-2">Cancel</a>
  </div>
</form>

<script>
  const checkboxes = document.querySelectorAll('.employee-checkbox');
  const countEl = document.getElementById('selectedCount');

  function updateCount() {
    const n = document.querySelectorAll('.employee-checkbox:checked').length;
    countEl.textContent = n + ' selected';
  }
  checkboxes.forEach(cb => cb.addEventListener('change', updateCount));
  updateCount();

  document.getElementById('selectAll').addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = true);
    updateCount();
  });
  document.getElementById('deselectAll').addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = false);
    updateCount();
  });
</script>
@endsection
