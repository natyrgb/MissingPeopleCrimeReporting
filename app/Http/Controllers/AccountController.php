<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth:employee');
    }

    // returns view of superadmin home
    public function editAccount() {
        $employee = Auth::guard('employee')->user();
        return view(strtolower($employee->role).'.edit_account', ['employee' => $employee]);
    }

    public function updateAccount(Request $request, Employee $employee) {
        $request->validate([
            'name' => 'required|string',
            'email' => [
                'required', 'email',
                Rule::unique('employees')->ignore($employee)
            ],
            'phone' => [
                'required', 'string',
                Rule::unique('employees')->ignore($employee)
            ],
            'password' => 'exclude_if:password_changed,1|string|min:8|confirmed',
            'old_password' => [
                'required', 'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('employee')->user()->password)) {
                        $fail('Old Password didn\'t match.');
                    }
                },
            ],
        ]);
        if($request->has('password'))
            $request['password'] = Hash::make($request['password']);
        $employee->fill($request->all());
        $employee->password_changed = true;
        $employee->save();
        return redirect('/'.strtolower($employee->role).'/home')->with('success', true);
    }
}
