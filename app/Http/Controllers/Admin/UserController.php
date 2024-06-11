<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withTrashed()->where('id_role', UserRole::Client)->get();

        return view('admin.user.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            toastr()->success('Khóa tài khoản thành công!');

            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Có lỗi khi khóa người dùng!');

            return redirect()->back();
        }
    }

    public function restore(string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore(); // Sử dụng phương thức restore để khôi phục người dùng

            toastr()->success('Mở khóa tài khoản thành công!');

            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Có lỗi khi mở khóa người dùng!');

            return redirect()->back();
        }
    }
}
