<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordExpiredRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\ResetLinkFormRequest;
use App\Mail\Auth\ForgotPassword;
use App\Mail\Auth\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
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
            'document_number' => ['required', 'exists:users,docuement_number'],
            'password' => ['required'],
        ]);

        $user = User::where('docuemnt_number', $request->number_document)->first();

            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $user->updated_at = Carbon::now();
                $user->save();

                return redirect()->route('admin.course.dashboard');
            } else {
                return redirect()->back()->withErrors(['password' => 'La contraseña es incorrecta']);
            }
        }

        return redirect()->back()->withErrors(['docuement_number' => 'El usuario no existe']);
    }

    public function expired()
    {
        return view('auth.passwords.expired');
    }

    public function postExpired(PasswordExpiredRequest $request)
    {
        // Checking current password
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->back()->with(['status' => '¡Contraseña actualizada correctamente!']);
    }

    public function createUser($request): User
    {
        $user = User::forceCreate(['email' => $request->email, 'password' => Hash::make($request->password)]);
        $user->assignRole('student');
        $personal_info = [
            'name' => $request->name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'gender_id' => $request->gender_id,
            'document_type_id' => $request->document_type_id,
            'document_number' => $request->document_number,
        ];

        $user->save($info);

        return $user;
    }

    public function register(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = null;
            $user = $this->createUser($request);
            Auth::login($user);

            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            $action_link = route('auth.verify.email', ['token' => $token, 'email' => $request->email]);
            $details = [
                'user_name' => $user->email,
                'action_link' => $action_link,
            ];
            $user->sendEmails($request->email, new VerifyEmail($details));

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
        /** @var \App\Models\User\User $user */
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([], 204);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['document_number' => ['required', 'exists:App\Models\User,document_number']], [
            'docuement_number.exists' => 'El numero de docuemento proporcionado no existe.',
        ]);
        $user = User::where('document_number', $request->document_number)->first();
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'document_number' => $request->document_number,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $action_link = route('auth.reset.password.form', ['token' => $token, 'document_number' => $request->document_number]);
        $user->id = encrypt($user->id);
        $details = [
            'user_name' => $user->name,
            'action_link' => $action_link,
        ];

        $user->sendEmails($request->email, new ForgotPassword($details));

        return redirect()->back()->with('message', 'Se ha enviado el correo correctamente!');
    }


    public function resetPassword(ResetLinkFormRequest $request)
    {
        $check_token = DB::table('password_reset_tokens')->where([
            'document_number' => $request->document_number,
            'token' => $request->token,
        ])->first();

        if (!$check_token) {
            return back()->with('fail', 'Este token ya fue usado o no exite');
        } else {
            User::where('document_number', $request->document_number)->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('password_reset_tokens')->where([
                'document_number' => $request->document_number,
            ])->delete();

            return redirect()->to('/login');
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(['token' => $token, 'document_number' => $request->document_number]);
    }

    // public function getUser(): JsonResponse
    // {
    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json([
    //             'user' => false,
    //             'exists' => false,
    //         ], 200);
    //     }

    //     return response()->json([
    //         'user' => $user,
    //         'exists' => true,
    //     ], 200);
    // }

 
}
