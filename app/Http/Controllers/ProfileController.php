<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('content.profile.profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
        ]);
        if ($request->pswcheckbox == "true" || $request->pswcheckbox == true) {
            $request->validate([
                'password' => 'min:8',
                'con_password' => 'min:8|same:password',
            ], [
                'con_password.same' => 'The confirm password and password must match.',
                'con_password.min' => 'The confirm password must be at least 8 characters.',

            ]);
        }
        try {
            $user = User::find($request->user_id);
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->email = $request->email;
            $user->phone = $request->phoneNumber;
            if ($request->pswcheckbox == "true" || $request->pswcheckbox == true) {
                $user->password = Hash::make($request->password);
            }
            $user->update();
            if (!empty($request->password)) {
                Auth::logoutCurrentDevice();
                return redirect()->route('login')->with('success', 'Your password successfully change. Please login your account using new password.');
            }
            return redirect()->back()->with('success', "You are successfully upadte.");
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
