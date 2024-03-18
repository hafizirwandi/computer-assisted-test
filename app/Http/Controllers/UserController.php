<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Sekolah;

class UserController extends Controller
{
    public function index()
    {
        $data['data'] = User::with(['roles', 'sekolah'])->get();

        return view('user.index', $data);
    }

    public function create()
    {
        $data['role'] = Role::all();
        $data['sekolah'] = Sekolah::all();
        return view('user.create', $data);
    }
    public function edit($id)
    {
        $data['role'] = Role::all();
        $data['sekolah'] = Sekolah::all();
        $data['data'] = User::with(['roles', 'sekolah'])->findOrFail($id);

        return view('user.edit', $data);
    }
    public function saveOrUpdate(Request $request, $id = null)
    {
        try {
            $rules = [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'email' => 'nullable|email', // email harus merupakan format email, bisa null
                'status' => 'required|in:0,1,2', // status harus berupa 0, 1, atau 2, tidak boleh null
                'sekolah_id' => 'nullable|numeric|exists:sekolah,id', // sekolah_id harus berupa angka dan ada di tabel sekolah
            ];
            if ($id != null) {


                $user = User::with('roles')->findOrFail($id);
                $data = $request->validate($rules);
                if ($request->input('password2')) {
                    $data['password'] =  Hash::make(($request->input('password2')));
                }

                $user->where('id', $id)->update($data);
                //role
                $old_role = ($user->roles)[0]->name ?? null;
                if ($old_role != $request->input('role')) {
                    $user->assignRole($request->input('role'));
                    if ($old_role != null) {
                        $user->removeRole($old_role);
                    }
                }

                $user->assignRole($request->input('role'));
                $msg = 'User berhasil diperbaharui';
            } else {
                $data = $request->validate($rules);
                $data['password'] =  Hash::make(($request->input('password')));
                $user = User::create($data);
                //role
                $user->assignRole($request->input('role'));
                $msg = 'User berhasil dibuat';
            }
            return back()->with('success', $msg);
        } catch (\Exception $e) {

            return $e->getMessage();

            return back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Request $request)
    {
        try {
            User::destroy($request->input('id'));
            return back()->with('success', 'User deleted successfully');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }
}
