<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    public function index() {
        return view('superadmin.employees.index', ['employees' => Employee::all()]);
    }

    /**
     * @return view to create new employee with array of station objects
     */
    public function create() {
        return view('superadmin.employees.create', [
            'stations' => Station::all()
        ]);
    }

    /**
     * @param Illuminate\Http\Request object
     * validates and create employee entry
     * @return redirect to view of employees index with success message
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'station' => 'required|integer|exists:stations,id',
            'department' => 'nullable|integer|exists:departments,id',
            'role' => [
                'required',
                Rule::in(['POLICE', 'ATTORNEY', 'ADMIN', 'SUPERADMIN'])
            ],
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|unique:employees,phone',
        ]);
        Employee::create([
            'employee_id' => substr($request['role'], 0, 3) . strval(Employee::count()),
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make('secret'),
            'station_id' => $request['station'],
            'department_id' => $request['department'] == 0 ? null : $request['department'],
            'role' => $request['role'],
            'is_available' => true
        ]);
        return redirect()->route('superadmin.employees.index')->with('success',true);
    }

    public function show(Employee $employee) {}

    /**
     * @param App\Models\Employee object
     * @return view to edit employee with the blog object
     */
    public function edit(Employee $employee) {
        return view('superadmin.employees.edit', [
            'employee' => $employee,
            'stations' => Station::all()
        ]);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Employee objects
     * validates and update the employee object
     * @return redirect to view of employees index with success message
     */
    public function update(Request $request, Employee $employee) {
        $request->validate([
            'name' => 'required|string',
            'station' => 'required|integer|exists:stations,id',
            'department' => 'nullable|integer|exists:departments,id',
            'role' => [
                'required',
                Rule::in(['POLICE', 'ATTORNEY', 'ADMIN', 'SUPERADMIN'])
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('employees')->ignore($employee)
            ],
            'phone' => [
                'required', 'string', 'max:255',
                Rule::unique('employees')->ignore($employee)
            ],
        ]);
        $employee->fill([
            'name' => $request['name'],
            'station_id' => $request['station'],
            'department_id' => $request['department'] != null ? $request['department'] : null,
            'role' => $request['role'],
            'email' => $request['email'],
            'phone' => $request['phone']
        ]);
        $employee->save();
        return redirect()->route('superadmin.employees.index')->with('success',true);
    }

    /**
     * @param App\Models\Employee objects
     * deletes the employee object
     * @return redirect to view of employees index with success message
     */
    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect()->route('superadmin.employees.index')->with('success',true);
    }
}
