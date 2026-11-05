<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Theme;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        // dd(activeTheme());
        $roles = Role::with('permissions')->get()->except(1);
        $staffs = Admin::with('roles')->orderBy('role_id', 'asc')->get()->except(1);
        $themes = Theme::pluck('path', 'id');
        // dd($themes);
        return view('backEnd.admin.staffs.index', compact('staffs', 'roles', 'themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email',
            'phone' => 'nullable|unique:admins,phone',
        ], [
            'email.unique' => 'This email is already taken.',
            'phone.unique' => 'This phone number is already taken.',
        ]);

        $role = Role::findOrFail($request->role_id);
        $input = array_merge($request->all(), [
            'is_order_assign' => $request->is_order_assign ?? 0,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'role' => $role->name,
        ]);

        $staff = Admin::create($input);
        $staff->assignRole($role->name);

        return response()->json(['success' => 'Staff Created Successfully']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email,' . $request->id,
            'phone' => 'nullable|unique:admins,phone,' . $request->id,
        ], [
            'email.unique' => 'This email is already taken.',
            'phone.unique' => 'This phone number is already taken.',
        ]);

        $staff = Admin::find($request->id);
        $role = Role::findOrFail($request->role_id);

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'is_order_assign' => $request->is_order_assign ?? 0,
            'role_id' => $request->role_id,
            'role' => $role->name,
        ];

        // যদি পাসওয়ার্ড দেওয়া হয় শুধুমাত্র তখনই পাসওয়ার্ড আপডেট হবে
        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        }

        $staff->update($input);
        $staff->syncRoles($role->name);

        return response()->json(['success' => 'Staff Updated Successfully']);
    }

    public function status($id, $status)
    {
        Admin::find($id)->update([
            'status' => $status,
        ]);

        return back()->with('success', 'Staff Status Updated Successfully');
    }

    public function delete($id)
    {
        $admin = Admin::find($id);
        $admin->removeRole($admin->role);
        $admin->delete();

        return back()->with('success', 'Staff Deleted Successfully');
    }
}
