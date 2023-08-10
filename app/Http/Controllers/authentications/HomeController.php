<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function login()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        } else {
            return view('content.authentications.login');
        }
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember = isset($request->remember_me) ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            // dd(Auth::user());
            if (auth()->user()->status != 0) {
                return redirect()->route('dashboard');
            } else {
                Auth::logoutCurrentDevice();
                return back()->with('failed', 'The provided credentials is inactive please contact admin.')->onlyInput('email', 'password');
            }
        }

        return back()->with('failed', 'The provided credentials do not match our records.')->onlyInput('email', 'password');

    }

    public function forgotPass()
    {

        if (auth()->user()) {
            return redirect()->route('dashboard');
        } else {
            return view('content.authentications.forgot-password');
        }
    }

    public function forgotPassPost(Request $req)
    {
        $req->validate([
            'email' => 'required|email|exists:users,email',
        ],[
          'email.exists'=>'The selected email do not match our records.'
        ]);

        $user = User::where('email', $req->email)->first();
        if ($user) {
            $tokenAvail = ResetPassword::where('email', $req->email)->first();
            $token = md5(time() . $user->email . $user->first_name);
            $expireTime = Carbon::now()->addMinutes(30);
            if ($tokenAvail) {
                $tokenAvail->token = $token;
                $tokenAvail->expire = $expireTime;
                $tokenAvail->update();
            } else {
                $resetLink = new ResetPassword();
                $resetLink->email = $user->email;
                $resetLink->token = $token;
                $resetLink->expire = $expireTime;
                $resetLink->save();
            }

            $data = [
                'token' => $token,
            ];
            Mail::send('mail.forgot-password', $data, function ($message) use ($user) {
                $message->to($user->email, $user->first_name)
                    ->subject($user->first_name . ' - Reset Password Mail');
            });
            return redirect()->route('login')->with('success', 'Your Reset Password Link Has Been Sent Your Mail Address.');
        } else {
            return redirect()->back()->with('failed', 'Email Not Found.');
        }
    }

    public function reset_password_view($token)
    {
        $checkToken = ResetPassword::where('token', $token)->first();
        if ($checkToken) {
            $currentTime = Carbon::now();
            if ($checkToken->expire > $currentTime) {
                return view('content.authentications.reset-password', compact('checkToken'));
            } else {
                return redirect()->route('login')->with('failed', 'Token Expired.');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Token mis-matched.');
        }
    }
    public function reset_password_post(Request $req)
    {
        $req->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|string',
            'con_password' => [
                'required',
                'min:8',
                'same:password',
                'string'
            ],
        ], [
            'email.exists' => 'You are wrong user or unauthorized access.',
            'password.min' => 'The password must be at least 8 characters.',
            'con_password.min' => 'The confirm password must be at least 8 characters.',
            'con_password.required' => 'The confirm password field is required.',
            'con_password.same' => 'The confirm password and password must match.',
        ]);
        $user = User::where('email', $req->email)->first();
        $user->password = Hash::make($req->password);
        $user->update();
        ResetPassword::where('email', $req->email)->first()->delete();
        return redirect()->route('login')->with('success', "Dear! $user->first_name your password successfully changed. Please login your account using new password.");
    }
}
