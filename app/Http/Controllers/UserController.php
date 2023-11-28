<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserRequest;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }

    public function user($user)
    {
        $user = User::where('document_number', "=", $user)->get();
        return response()->json(['users' => $user], 200);
    }


    public function store(UserRequest $request)
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

            $role = Role::where('name', $request->type)->first();
            if ($role) {
                $user->assignRole($role);
            } else {
                return response()->json(['error' => 'El rol no existe.'], 404);
            }
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

    public function editProfile()
    {
        $user_information = Auth::user();
        return view('pages.profile', compact('user_information'));
    }

    public function updateProfile(Request $request,  $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return response()->json(['status' => true, 'saved' => true, 'user' => $user], 200);
    }


    public function create(Request $request)
    {
        $user = new User($request->all());
        $user->password = Hash::make($request->document_number);
        $user->save();

        $role = Role::where('name', $request->type)->first();
        if ($role) {
            $user->assignRole($role);
            return response()->json(['status' => 'User created', 'user' => $user], 201);
        } else {
            $user->delete();
            return response()->json(['error' => 'El rol no existe.'], 422);
        }
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        $role = Role::where('name', $request->type)->first();
        if ($role) {
            $user->syncRoles([$role->name]);
        } else {
            return response()->json(['error' => 'El rol no existe.'], 422);
        }

        return response()->json(['status' => 'User updated', 'user' => $user], 200);
    }
}
