<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    private function org() { return Auth::user()->organization; }

    public function index(Request $request)
    {
        $query = $this->org()->employees()->orderByDesc('phished_count');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('department', 'like', "%$search%");
            });
        }
        $employees = $query->paginate(25);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email',
            'department' => 'nullable|string|max:100',
            'position'   => 'nullable|string|max:100',
        ]);

        $org = $this->org();
        if ($org->employees()->where('email', $data['email'])->exists()) {
            return back()->withErrors(['email' => 'This email already exists.'])->withInput();
        }

        $org->employees()->create($data);
        return redirect()->route('employees.index')->with('success', 'Employee added.');
    }

    public function importCsv(Request $request)
    {
        $request->validate(['csv' => 'required|file|mimes:csv,txt|max:2048']);

        $org   = $this->org();
        $file  = $request->file('csv');
        $lines = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_map('strtolower', array_map('trim', array_shift($lines)));

        $imported = 0;
        foreach ($lines as $row) {
            $row = array_combine($header, $row);
            if (empty($row['email'])) continue;
            $org->employees()->updateOrCreate(
                ['email' => trim($row['email'])],
                [
                    'first_name' => trim($row['first_name'] ?? $row['firstname'] ?? ''),
                    'last_name'  => trim($row['last_name'] ?? $row['lastname'] ?? ''),
                    'department' => trim($row['department'] ?? ''),
                    'position'   => trim($row['position'] ?? $row['title'] ?? ''),
                ]
            );
            $imported++;
        }

        return redirect()->route('employees.index')->with('success', "$imported employees imported.");
    }

    public function destroy(Employee $employee)
    {
        abort_if($employee->organization_id !== $this->org()->id, 403);
        $employee->delete();
        return back()->with('success', 'Employee removed.');
    }
}
