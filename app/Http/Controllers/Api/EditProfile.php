<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditProfile extends Controller
{

    public function editProfile(Request $request)
    {
        // Get the bearer token from the request
        $token = $request->bearerToken();

        // Find the user with the given token
        $user = pelanggan::where('token', $token)->first();

        // If user is not found, return a user not found message
        if (!$user) {
            return $this->sendMassage('User not found', 404, false);
        }

        // Define the validation rules for each field
        $rules = [
            'nama' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:pelanggans,email,' . $user->id,
            'no_telfon' => 'sometimes|required|string|max:15|unique:pelanggans,no_telfon,' . $user->id,
        ];

        // Validate the request with the defined rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, return the first error message
        if ($validator->fails()) {
            return $this->sendMassage($validator->errors()->first(), 400, false);
        }

        // Update only the fields that are present in the request
        if ($request->has('nama')) {
            $user->nama = $request->input('nama');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        if ($request->has('no_telfon')) {
            $user->no_telfon = $request->input('no_telfon');
        }

        // Save the updated user
        $user->save();

        // Return the updated user information with a success message
        return $this->sendMassage($user, 200, true);
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
