<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        $title = 'المستخدمين';
        $button = [
            'title' => 'اضافة موظف',
            'route' => route('users.create'),
        ];
        return $dataTable->render('common.table-page', compact('title', 'button'));
    }

    public function show(User $user)
    {
        return view('dashboard.users.show', compact('user'));
    }
    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'national_id' => 'required|unique:users',
            'avatar' => 'image',
            'address' => 'string',
            'password' => 'required',
            'role' => 'required|in:admin,user',
        ]);
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->only(['name', 'email', 'password', 'national_id', 'address']));
        $user->assignRole($request->role);
        if ($request->hasFile('avatar')) {
            $user->update(['avatar' => $request->file('avatar')->store('uploads')]);
        }
        return redirect()->route('users.index')->with('success', 'تم اضافة المستخدم بنجاح');
    }
}
