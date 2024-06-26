<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
public function lupapassword() {
    return view('lupa_password');
    
}
    public function postlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            alert('Gagal', $validator->messages());
            return redirect()->back()->withInput();
        }

        $credentials = [
            "username" => $request->username,
            "password" => $request->password
        ];
        // dd($credentials);
        try {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
Alert::success('Berhasil Login')->flash();
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            // dd("dsdsds");
            //throw $th;
            alert()->error('Gagal', $th->getMessage());
            return back();
            //     alert()->error('Gagal',"nis/nip atau password salah");
            // return back();
        }
    }

    public function resetpassword(Request $request)  {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->token);
        $token=PasswordResetToken::where('token', $request->token)->first();    
        if (!$token) {
            Alert::error("Token Tidak Valid")->flash();
            return redirect()->route('login');
        }
        $user=User::where('email', $token->email)->first();
        if (!$user) {
            Alert::error("email tidak di temukan")->flash();
            return redirect()->route('login');
        }
        $user->update(['password' => bcrypt($request->password)]);
        $token->delete();
        Alert::success("Password Berhasil Di ubah, silahkan login dengan password baru")->flash();
        return redirect()->route('login');
        
    }
public function actlupapassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $email = $request->email;
        $token=\Str::random(60);
        PasswordResetToken::updateOrCreate([
            'email' => $email
        ],[
            'email' => $email,
            'token' =>$token,
            'created_at' => now(),
        ]);
      
        try {
            //code...
              Mail::to("$email")->send(new ResetPasswordMail($token));
        } catch (\Throwable $th) {
            Alert::error($th)->flash();
        }
        Alert::success('Kami Telah Mengirimkan Link Untuk Mengatur Ulang Password')->flash();
        return redirect()->route('lupapassword');
    }

    public function validasilupapassword(Request $request,$token) {
  $token = PasswordResetToken::where('token', $token)->first();
$tokenn=$token->token;
        if (!$token) {
            return redirect()->route('lupapassword');
        }
        return view('reset_password',compact('token','tokenn'));    
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

 
}
