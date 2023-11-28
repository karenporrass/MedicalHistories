<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends controller
{
    public function login(Request $request)
    {
        $validator = $request->validate([
            'document_number' => ['required', 'exists:users,document_number'],
            'password' => ['required'],
        ]);

        $user = User::where('document_number', $request->document_number)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $user->updated_at = Carbon::now();
            $user->save();
            if ($user->type == 'professional') {
                return redirect()->route('medical.history.histories-professional');
            } else {
                return redirect()->route('medical.history.histories-patient');
            }
        } else {
            return redirect()->back()->withErrors(['password' => 'La contraseña es incorrecta']);
        }

        return redirect()->back()->withErrors(['document_number' => 'El usuario no existe']);
    }




    public function register(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = null;
            $user = User::forceCreate([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->phone,
                'type' => $request->type,
                'document_number' => $request->document_number,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->assignRole($request->type);
            Auth::login($user);

            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'docuement_number' => $user->docuement_number,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            DB::commit();

            return redirect()->route('index');
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'errors' => [$e->getMessage(), $e->getTrace()],
                'saved' => false,
            ], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }
}
