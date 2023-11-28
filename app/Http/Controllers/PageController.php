<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    public function initial()
    {
        $user = Auth::user();
        if ($user == 'professional') {
            return redirect()->route('medical.history.histories-professional');
        } elseif ($user == 'patient') {
            return redirect()->route('medical.history.histories-patient');
        } else {
            return view('welcome');
        }
    }
}
