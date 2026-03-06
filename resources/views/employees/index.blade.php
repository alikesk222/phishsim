@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="flex items-center justify-between mb-6">
  <div>
    <h1 class="text-2xl font-bold">Employees</h1>
    <p class="text-gray-500 text-sm mt-1">{{ $employees->total() }} employees in your organization</p>
  </div>
  <div class="flex gap-3">
    <form method="POST" action="{{ route('employees.import') }}" enctype="multipart/form-data" class="flex items-center gap-2">
      @csrf
      <label class="text-sm text-gray-400 hover:text-white cursor-pointer">
        <span class="bg-gray-800 border border-gray-700 px-3 py-2 rounded-lg text-sm hover:border-gray-600 transition-colors">Import CSV</span>
        <input type="file" name="csv" accept=".csv" class="hidden" onchange="this.form.submit()">
      </label>
    </form>
    <a href="{{ route('employees.create') }}"
      class="bg-red-600 hover:bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
      + Add Employee
    </a>
  </div>
</div>

{{-- Search --}}
<form method="GET" class="mb-4">
  <input type="text" name="search" value="{{ request('search') }}"
    placeholder="Search by name, email, or department..."
    class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500">
</form>

@if($employees->isEmpty())
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-12 text-center">
    <svg class="w-12 h-12 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    <p class="text-gray-400 font-medium mb-1">No employees found</p>
    <p class="text-gray-600 text-sm mb-4">Add employees manually or import a CSV file.</p>
    <a href="{{ route('employees.create') }}" class="bg-red-600 hover:bg-red-500 text-white text-sm px-4 py-2 rounded-lg transition-colors">
      Add Employee
    </a>
  </div>
@else
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800 text-gray-500 text-xs uppercase tracking-wide">
          <th class="text-left px-5 py-3">Name</th>
          <th class="text-left px-5 py-3">Email</th>
          <th class="text-left px-5 py-3">Department</th>
          <th class="text-left px-5 py-3">Risk Level</th>
          <th class="text-left px-5 py-3">Phished</th>
          <th class="text-left px-5 py-3">Active</th>
          <th class="px-5 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        @foreach($employees as $employee)
          <tr class="hover:bg-gray-800/50 transition-colors">
            <td class="px-5 py-4 font-medium">{{ $employee->full_name }}</td>
            <td class="px-5 py-4 text-gray-400">{{ $employee->email }}</td>
            <td class="px-5 py-4 text-gray-400">{{ $employee->department ?? '—' }}</td>
            <td class="px-5 py-4">
              <span class="text-xs px-2 py-1 rounded-full
                {{ $employee->risk_level === 'critical' ? 'bg-red-900/40 text-red-400' : '' }}
                {{ $employee->risk_level === 'high' ? 'bg-orange-900/40 text-orange-400' : '' }}
                {{ $employee->risk_level === 'medium' ? 'bg-yellow-900/40 text-yellow-400' : '' }}
                {{ $employee->risk_level === 'low' ? 'bg-green-900/40 text-green-400' : '' }}
              ">{{ ucfirst($employee->risk_level) }}</span>
            </td>
            <td class="px-5 py-4 text-gray-400">{{ $employee->phished_count }}x</td>
            <td class="px-5 py-4">
              @if($employee->is_active)
                <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
              @else
                <span class="inline-block w-2 h-2 rounded-full bg-gray-600"></span>
              @endif
            </td>
            <td class="px-5 py-4 text-right">
              <div class="flex items-center justify-end gap-3">
                <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-gray-600 hover:text-red-400 text-xs"
                    onclick="return confirm('Delete {{ $employee->full_name }}?')">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $employees->withQueryString()->links() }}
  </div>
@endif
@endsection
