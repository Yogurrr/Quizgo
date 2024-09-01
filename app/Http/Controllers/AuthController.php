<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Set;
use Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('quizgo')->withSuccess('Signed in');
        }

        return redirect("/")->withSuccess('Login details are not valid');
    }

    public function Logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }

    public function join(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'birth_date' => 'required',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        
        return redirect("/")->withSuccess('You have signed-in');
    }

    public function forgotton()
    {
        return view('auth/forgotton');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'birth_date' => $data['birth_date'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
        ]);
    }

    public function settings()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $userinfo = User::where('id', $id)->get();

            return view('auth/settings', compact('userinfo'));
        }
        return redirect("/");
    }

    public function updateProfile(Request $request)
    {
        User::whereId(auth()->user()->id)->update([
            'profile' => ($request->profile)
        ]);

        return back()->with("status", "프로필 사진이 성공적으로 변경되었습니다!");
    }

    public function updateName(Request $request)
    {
        User::whereId(auth()->user()->id)->update([
            'name' => ($request->name)
        ]);

        return back()->with("status", "이름이 성공적으로 변경되었습니다!");
    }

    public function updateEmail(Request $request)
    {
        User::whereId(auth()->user()->id)->update([
            'email' => ($request->email)
        ]);

        return back()->with("status", "이메일이 성공적으로 변경되었습니다!");
    }

    public function deleteAccount(Request $request) 
    {
        $email = User::select('email')->whereId(auth()->user()->id)->first()->email;
        if(Set::where('email', $email)->exists()) {
            Set::where('email', $email)->delete();
        }
        User::whereId(auth()->user()->id)->delete();

        return redirect("/");
    }
}
