<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Farmer;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class PlantController extends Controller
{
    public function addNewPlant(Request $request, $farmer_id) {
         // $auth = $request->user();
        // if ($auth->tokenCan("2")) {
            $fields = $request->validate([
                'remain' => 'required|integer',
                'addonAmount' => 'required|integer',
                'addonSpecies' => 'required|string',
                'expectedDate' => 'required|string',
                'expectedAmount' => 'required|numeric',
            ]);
            $plant = Plant::create([
                'farmer_id' => $farmer_id,
                'remain_plant' => $fields['remain'],
                'addon_plant' => $fields['addonAmount'],
                'addon_species' => $fields['addonSpecies'],
                // date_for_harvest
                'date_for_harvest' => Carbon::createFromFormat('d/m/Y', $fields['expectedDate'])->format('Y-m-d'),
                // quantity_for_harvest
                'quantity_for_harvest' => $fields['expectedAmount'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response("New Plant Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showPlantsByFarmer(Request $request, $farmer_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0") || $auth->tokenCan("2")) {
            $plant = Farmer::find($farmer_id)->plants;
            $farmer = Farmer::find($farmer_id);
            $user = User::find($farmer['user_id']);
            $enterprise = Enterprise::find($farmer['enterprise_id']);
            $data = [
                "farmer" => $farmer,
                "user" => $user,
                "enterprise" => $enterprise,
                "plant" => $plant,
            ];

            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function getLatestPlant(Request $request, $farmer_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("2")) {
            $farmer = Farmer::find($farmer_id);
            $remain_amount = $farmer->received_amount;

            $plant = Farmer::find($farmer_id)->getCurrentPlants;
            $addon_amount = 0;
            if(count($plant) > 0) {
                $remain_amount = $plant->first()->remain_plant;
                $addon_amount = $plant->first()->addon_plant;
            }
            $data = [
                "remain" => $remain_amount,
                "addon" => $addon_amount,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function countAllFarmerPlant(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $farmers = Farmer::all();
            $count = 0;
            // $plants = [];
            foreach ($farmers as $f) {
                $plant = Farmer::find($f['id'])->plants->first();
                if($plant == null) {
                    $count = $count + $f['received_amount'];
                    // array_push($plants, $f['received_amount']);
                }
                else {
                    $count = $count + $plant['remain_plant'];
                    // array_push($plants, $plant);
                }
            }
            $data = [
                "num" => $count,
            ];
            return response($data, 200);
         // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

}
