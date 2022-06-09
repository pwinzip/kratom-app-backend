<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    public function addNewFarmer(Request $request)
    {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
        $fields = $request->validate([
            'farmerName'     => 'required|string',
            'farmerTel'      => 'required|string|unique:users,tel',
            'farmerPassword' => 'required|string',
            'farmerAddress'  => 'required|string',
            'farmerArea'     => 'required|numeric',
            'farmerLat'      => 'required|numeric',
            'farmerLong'     => 'required|numeric',
            'farmerReceived' => 'required|integer',
            'enterpriseId'   => 'required|integer',
            'isActive'       => 'required|integer',
        ]);
        $user = User::create([
            "name"       => $fields['farmerName'],
            "tel"        => $fields['farmerTel'],
            "password"   => Hash::make($fields['farmerPassword']),
            "is_active"  => $fields['isActive'],
            "role"       => 2, // farmer
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $farmer = Farmer::create([
            "user_id"         => $user->id,
            "address"         => $fields['farmerAddress'],
            "area"            => $fields['farmerArea'],
            "lat"             => $fields['farmerLat'],
            "long"            => $fields['farmerLong'],
            "received_amount" => $fields['farmerReceived'],
            "enterprise_id"   => $fields['enterpriseId'],
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ]);

        return response("New Farmer Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function editFarmer(Request $request, $farmer_id)
    {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
        $fields = $request->validate([
            'farmerName'     => 'required|string',
            'farmerTel'      => 'required|string',
            'farmerAddress'  => 'required|string',
            'farmerArea'     => 'required|numeric',
            'farmerLat'      => 'required|numeric',
            'farmerLong'     => 'required|numeric',
            'farmerReceived' => 'required|integer',
            'enterpriseId'   => 'required|integer',
            'isActive'       => 'required|integer',
        ]);
        $farmer = Farmer::find($farmer_id);
        User::where('id', $farmer['user_id'])
            ->update([
                'name'      => $fields['farmerName'],
                'tel'       => $fields['farmerTel'],
                'is_active' => $fields['isActive'],
            ]);
        if(!empty($request['farmerPassword'])) {
            $up = User::where('id', $farmer['user_id'])
                    ->update([
                        'password' => Hash::make($request['farmerPassword'])
                    ]);
        }
        Farmer::where('id', $farmer_id)
            ->update([
                'address'         => $fields['farmerAddress'],
                'area'            => $fields['farmerArea'],
                'lat'             => $fields['farmerLat'],
                'long'            => $fields['farmerLong'],
                'received_amount' => $fields['farmerReceived'],
                'enterprise_id'   => $fields['enterpriseId'],
            ]);

        return response("Farmer Updated", 200);
        // return response($up, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showAllFarmer(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
        $users = User::where('role',2)
                    //  ->where('is_active',1)
                    ->orderBy('created_at', 'desc')
                    ->get();
        $user_arr = [];
        foreach ($users as $u) {
            $farmer = User::find($u['id'])->farmers;
            $enterprise = Farmer::find($farmer['id'])->enterprises;
            $plants = Farmer::find($farmer['id'])->plants->first();
            $remain = 0;
            if($plants == null) {
                $remain = $farmer['received_amount'];
            }
            else {
                $remain = $plants['remain_plant'];
            }
            $newarr = [
            "farmer_id" => $farmer['id'],
            "user_id" => $u['id'],
            "name" => $u['name'],
            "ent_name" => $enterprise['enterprise_name'],
            "remain" => $remain,
            ];
            array_push($user_arr, $newarr);
        }

        $data = [
            "farmers" => $user_arr,
        ];
        return response($data, 200);
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
    }

    public function showFarmer($farmer_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0") || $auth->tokenCan("1") || $auth->tokenCan("1")) {
            $farmer = Farmer::find($farmer_id);
            $user = Farmer::find($farmer_id)->users;
            $plant = Farmer::find($farmer_id)->plants->first();
            $enterprise = Farmer::find($farmer_id)->enterprises;
            $data = [
                "farmer" => $farmer,
                "user" => $user,
                "plant" => $plant,
                "enterprise" => $enterprise,
                "agent" => User::find($enterprise['agent_id']),
            ];

            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function farmerNumber(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            // $num = Farmer::join('users', 'users.id', "=", "farmers.user_id")
            //             ->where('users.is_active', 1)
            //             ->count();
            $num = User::where('role', 2)
                        ->count();
            $data = [
                'num' => $num,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    // public function showFarmers(Request $request, $enterpriseid)
    // {
    //     // $auth = $request->user();
    //     // if ($auth->tokenCan("0") || $auth->tokenCan("1")) {
    //         $farmers    = Enterprise::find($enterpriseid)->farmers;
    //         $farmerlist = [];
    //         foreach ($farmers as $f)
    //         {
    //             $farmer = Farmer::find($f->id);
    //             $user = $farmer->users;
    //             if ($user->is_active == 1) {
    //                 $plants = $farmer->plants;
    //                 // $user   = Farmer::find($f->id)->users;
    //                 // $plants = Farmer::find($f->id)->plants;
    //                 $remain = $plants->count() > 0 ? $plants->first()->remain_plant : $f->received_amount;
    //                 // if($plants->count() > 0) {
    //                 //     $remain = $plants->first()->remain_plant;
    //                 // }
    //                 // else {
    //                 //     $remain = $f->received_amount;
    //                 // }
    //                 $new_arr = [
    //                     "farmer"     => $f,
    //                     "user"       => $user,
    //                     "remain"     => $remain,
    //                     // "id" => $f->id,
    //                     // "address" => $f->address,
    //                     // "area" => $f->area,
    //                     // "lat" => $f->lat,
    //                     // "long" => $f->long,
    //                     // "userid" => $user->id,
    //                     // "name" => $user->name,
    //                     // "tel" => $user->tel,
    //                     // "remain" => $remain,
    //                     // "created_at" => $user->created_at,
    //                 ];
    //                 array_push($farmerlist, $new_arr);
    //             }
    //         }
    //         $data = [
    //             "payload" => $farmerlist,
    //         ];

    //         return response($data, 200);
    //     // } else {
    //     //     return response('Permission Denied.', 403);
    //     // }
    // }

    

    // public function getAmountPlants($id) { // getAmountPlants
    //     $farmer = Farmer::find($id);
    //     $remain_amount = $farmer->received_amount;
    //     $addon_amount = 0;
    //     $plant = Farmer::find($id)->getCurrentPlants;
    //     if(count($plant) > 0) {
    //         $remain_amount = $plant->first()->remain_plant;
    //         $addon_amount = $plant->first()->addon_plant;
    //     }

    //     $data = [
    //         "remain" => $remain_amount,
    //         "addon" => $addon_amount,
    //     ];

    //     return response($data, 200);
    // }

    // public function getAllPlants($id) {
    //     $plant = Farmer::find($id)->plants;
    //     $data = [
    //         "payload" => $plant,
    //     ];

    //     return response($data, 200);
    // }

    // public function addPlants(Request $request, $id) {
    //     $fields = $request->validate([
    //         'remain' => 'required|integer',
    //         'addonAmount' => 'required|integer',
    //         'addonSpecies' => 'required|string',
    //         'expectedDate' => 'required|string',
    //         'expectedAmount' => 'required|numeric',
    //     ]);
    //     $plant = Plant::create([
    //         'farmer_id' => $id,
    //         'remain_plant' => $fields['remain'],
    //         'addon_plant' => $fields['addonAmount'],
    //         'addon_species' => $fields['addonSpecies'],
    //         'date_for_sale' => Carbon::createFromFormat('d/m/Y', $fields['expectedDate'])->format('Y-m-d'),
    //         'quantity_for_sale' => $fields['expectedAmount'],
    //         'created_at' => Carbon::now(),
    //         'updated_at' => Carbon::now(),
    //     ]);
    //     return response("New Plant Added", 200);
    // }
}
