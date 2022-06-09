<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function resetPassword(Request $request, $user_id){
        $fields = $request->validate([
            'password' => 'required|string'
        ]);
        $update = User::where('id', $user_id)->update([
            'password' => $fields['password'],
        ]);

        return response($update, 200);

    }

    public function login(Request $request){
        $fields = $request->validate([
            'tel' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('tel', $fields['tel'])
                      ->where('is_active', 1)
                      ->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid Login',
            ], 401);
        } else {
            $user->tokens()->delete();
            $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken;

            if($user->role == 2) {
                $farmer = User::find($user->id)->farmers;
                $enterprise = Farmer::find($farmer->id)->enterprises;
                $agent = Enterprise::find($enterprise->id)->users;
                $response = [
                    'user' => $user,
                    'farmer' => $farmer,
                    'enterprise' => $enterprise,
                    'agent' => $agent,
                    'token' => $token,
                ];
                return response($response, 200);
            }
            else if ($user->role == 1) {
                $enterprise = User::find($user->id)->enterprises;
                $response = [
                    'user' => $user,
                    'enterprise' => $enterprise,
                    'token' => $token,
                ];
                return response($response, 200);
            }
            else if ($user->role == 0) {
                $response = [
                    'user' => $user,
                    'token' => $token,
                ];
                return response($response, 200);
            }
        }
    }
    
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'Logged out',
        ], 200);
    }
}
