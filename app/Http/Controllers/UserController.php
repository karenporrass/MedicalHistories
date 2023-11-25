<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
       
    public function index()
    {
        $users= User::all();

        return response()->json(['users' => $users], 200);
    }

    public function editProfile(): view
    {
        $user = Auth::user();
        $userInformation = User::where($user->id)->get();
        return view('profile.profile', compact('user_information'));
    }


    public function updateProfile(UserRequest $request)
    {
        $user = Auth::user();
            $userInformation = User::find($user->id);
            $userlInformation->update($request->except('_token'));
       
        return redirect()->back()->with('message', 'información personal guardada');
    }
 

}
