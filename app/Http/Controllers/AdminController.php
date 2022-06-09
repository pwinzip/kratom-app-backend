<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function addNewUser(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $fields = $request->validate([
                'name' => 'required|string',
                'tel' => 'required|string|unique:users,tel',
                'password' => 'required|string',
                'role' => 'required|integer',
            ]);
            $user = User::create([
                "name" => $fields['name'],
                "tel" => $fields['tel'],
                "password" => Hash::make($fields['password']),
                "is_active" => 1,
                "role" => $fields['role'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response("New User Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showAdmins(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $admins = User::where('role', 0)->get();
            return response($admins, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function agentNumber(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $agents = User::where('role', 1)
                        ->count();
            $data = [
                'num' => $agents,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    // public function editUser(Request $request, $user_id) {
    //     // $auth = $request->user();
    //     // if ($auth->tokenCan("0")) {
    //         $fields = $request->validate([
    //             'name' => 'required|string',
    //             'tel' => 'required|string',
    //             'password' => 'required|string',
    //             'isActive' => 'required|integer',
    //         ]);
    //         User::where('id', $user_id)
    //               ->update([
    //                   'name' => $fields['name'],
    //                   'tel' => $fields['tel'],
    //                   'password' => Hash::make($fields['password']),
    //                   'is_active' => $fields['isActive'],
    //               ]);
    //         return response("User Updated", 200);
    //     // } else {
    //     //     return response('Permission Denied.', 403);
    //     // }
    // }

    

    // public function changStatus(Request $request, $user_id) {
    //     // $auth = $request->user();
    //     // if ($auth->tokenCan("0")) {
    //     $user = User::find($user_id);
    //     $status = $user->is_active;
    //     User::find($user_id)->update([
    //         'is_active' => $user->is_active == 1? 0 : 1,
    //     ]);
    //     return response("Success",200);
        
    //     // } else {
    //     //     return response('Permission Denied.', 403);
    //     // }
    // }

    

    // public function countAllEnterprisesAndMembers(Request $request) {
    //     $countEnterprise = Enterprise::all()->count();
    //     $countFarmer = Farmer::all()->count();
    //     $data = [
    //         "countEnterprise" => $countEnterprise,
    //         "countFarmer" => $countFarmer,
    //     ];
    //     return response($data, 200);
    // }
}
