<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    /**
     * @return view of employees index with object of all employees of the station
     */
    public function index() {
        $admin = Auth::guard('employee')->user();
        return view('admin.employees.index', ['employees' => $admin->station->employees]);
    }

    /**
     * @return view to create employees with object of all departments of the station
     */
    public function create() {
        $admin = Auth::guard('employee')->user();
        return view('admin.employees.create', ['departments' => $admin->station->departments]);
    }

    /**
     * @param Illuminate\Http\Request object with form inputs
     * validate input and create an employee of that station
     * @return if validation is successful redirect to view of employees index with success
     * @return if validation fails redirect back with validation errors
     */
    public function store(Request $request) {
        $admin = Auth::guard('employee')->user();
        $request->validate([
            'name' => 'required|string',
            'department' => 'nullable|integer|exists:departments,id',
            'role' => [
                'required',
                Rule::in(['POLICE', 'ATTORNEY'])
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
            'station_id' => $admin->station_id,
            'department_id' => $request['department'] == 0 ? null : $request['department'],
            'role' => $request['role'],
            'is_available' => true
        ]);
        return redirect()->route('admin.employees.index')->with('success',true);
    }

    public function show(Employee $employee) {}

    /**
     * @param App\Models\Employee object
     * @return view of employee edit with the employee object and departments of the station
     */
    public function edit(Employee $employee) {
        $admin = Auth::guard('employee')->user();
        return view('admin.employees.edit', [
            'employee' => $employee,
            'departments' => $admin->station->departments
        ]);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Employee object with form inputs
     * validate input and update the given employee
     * @return if validation is successful redirect to view of employees index with success
     * @return if validation fails redirect back with validation errors
     */
    public function update(Request $request, Employee $employee) {
        $request->validate([
            'name' => 'required|string',
            'department' => 'nullable|integer|exists:departments,id',
            'role' => [
                'required',
                Rule::in(['POLICE', 'ATTORNEY'])
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
        $request['department_id'] = $request->role == 'ATTORNEY' ? null : $request->department;
        $employee->fill($request->all());
        $employee->save();
        return back()->with('success',true);
    }

    /**
     * @param App\Models\Employee object
     * delete the given employee
     * @return redirect to view of employees index with success
     */
    public function destroy(Employee $employee) {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success',true);
    }
}
