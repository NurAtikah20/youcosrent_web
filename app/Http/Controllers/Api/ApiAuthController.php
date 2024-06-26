<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerifMail;
use App\Models\pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    private VerifMail $verifMail;
    public function __construct()
    {
        $this->verifMail = new VerifMail();
    }
    public function loginUser(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $dataEmail = $request->email;
        $dataTokenFcm = $request->token_fcm;

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $customer = pelanggan::where('email', $dataEmail)->first();
            if ($customer) {
                if ($customer->email_verified == true) {
                    if (Hash::check($request->password, $customer->password)) {
                        $token = Str::random(200);
                        pelanggan::where('email', $dataEmail)->update([
                            'token' => $token,
                        ]);
                        $dataCustomer = pelanggan::where('email', $dataEmail)->first();
                        return $this->sendMassage($dataCustomer, 200, true);
                    }
                    return $this->sendMassage('Password salah', 400, false);
                }
                return $this->sendMassage('Akun anda belum terverifikasi', 400, false);
            }
            return $this->sendMassage('Username tidak ditemukan', 400, false);
        }
    }

    public function registerUser(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $dataEmail = $request->input('email');
            $customer = pelanggan::where('email', $dataEmail)->first();
            if ($customer) {
                return $this->sendMassage('Akun yang anda gunakan telah terdapat pada list, lakukan aktifasi terlebih dahulu', 400, false);
            } else {
                $isRegister = pelanggan::create([
                    'nama' => $request->input('name'),
                    'username' => $request->input('username'),
                    'no_telfon' => $request->input('no_telepon'),
                    'jenis_kelamin' => $request->input('jenis_kelamin'),
                    'alamat' => $request->input('alamat'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ]);
                if (isset($isRegister)) {
                    $dataUser = [
                        'email' => $dataEmail,
                        'kode' => null
                    ];
                    $this->verifMail->dataUser = $dataUser;
                    Mail::to($request->input('email'))->send($this->verifMail);
                    return response()->json([
                        'data' => "Selamat anda berhasil registrasi, Silahkan Cek Email Anda untuk aktivasi akun",
                        'code' => 200,
                        'status' => true
                    ], 200);
                }
            }
        }
    }

    public function verified($id)
    {

        $editCustomer = pelanggan::where("email", $id)->first()->update([
            'email_verified' => true
        ]);

        if ($editCustomer) {
            $hasil = pelanggan::where("email", $id)->first();
            return view('email.notifikasiEmail', compact('hasil'))->with([
                'data' => $hasil->email_verified,
                'code' => 200,
                'status' => true
            ]);
        } else {
            $hasil = "Kesalahan akun";
            return view('email.notifikasiEmail')->with([
                'data' => 'salah',
                'code' => 400,
                'status' => false
            ]);
        }
    }


    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}
