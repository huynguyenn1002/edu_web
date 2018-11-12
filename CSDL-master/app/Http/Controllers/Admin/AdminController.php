<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use AuthenticatesUsers;
    public function showLogin()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $admin=$request['email'];
        $password=$request['password'];

        if (auth()->guard('admin')->attempt(['email' => $admin, 'password' => $password], $request->remember))
        {
            return redirect()->route('admin.home');
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function home()
    {
        return view('admin.home');
    }

    public  function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.show_login');
    }
    //Users
    //Admin
    public function createAdmin()
    {
        return view('admin.create');
    }
    public function profile($id)
    {
        $admin=Admin::findOrFail($id);
        return view('admin.profile',['admin'=>$admin]);
    }
    public function update(Request $request,$id)
    {
        $admin=Admin::findOrFail($id);
        $admin->update([
            'name'=> $request['name'],
            'email'=>$request['email'] ,
            'DOB'=>$request['birthday'],
            'address'=> $request['address'],

        ]);
        return view('admin.profile',['admin'=>$admin])->with('Success','Admin profile updated successfully ');
    }
    public function edit($id)
    {
        $admin=Admin::findOrFail($id);
        return view('admin.edit',['admin'=>$admin]);
    }

    //Catagories

    //
    public function guard()
    {
        return Auth::guard('admin');
    }
}
