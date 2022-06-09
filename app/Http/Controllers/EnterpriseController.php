<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use App\Models\Farmer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnterpriseController extends Controller
{
    public function addNewEnterprise(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $fields = $request->validate([
                'registNo' => 'required|string|unique:enterprises,regist_no',
                'enterpriseName' => 'required|string',
                'enterpriseAddress' => 'required|string',
                'agentName' => 'required|string',
                'password' => 'required|string',
                'tel' => 'required|string',
            ]);

            $user = User::create([
                "name" => $fields['agentName'],
                "tel" => $fields['tel'],
                "password" => Hash::make($fields['password']),
                "role" => 1,
                "is_active" => 1
            ]);
            $enterprise = Enterprise::create([
                "regist_no" => $fields['registNo'],
                "enterprise_name" => $fields['enterpriseName'],
                "address" => $fields['enterpriseAddress'],
                "agent_id" => $user->id,
                "is_active" => 1,
            ]);
            return response("New Enterprise Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function editEnterprise(Request $request, $enterprise_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $fields = $request->validate([
                'registNo' => 'required|string',
                'enterpriseName' => 'required|string',
                'enterpriseAddress' => 'required|string',
                'agentName' => 'required|string',
                'agentTel' => 'required|string',
                'isActive' => 'required|integer',
            ]);
            $enterprise = Enterprise::find($enterprise_id);
            
            User::where('id', $enterprise['agent_id'])
                        ->update([
                            'name' => $fields['agentName'],
                            'tel' => $fields['agentTel'],
                            'is_active' => $fields['isActive'],
                        ]);

            if(!empty($request['agentPassword'])) {
                User::where('id', $enterprise['agent_id'])
                        ->update([
                            'password' => Hash::make($request['agentPassword']),
                        ]);
            }
            Enterprise::where('id', $enterprise_id)
                        ->update([
                            'regist_no' => $fields['registNo'],
                            'enterprise_name' => $fields['enterpriseName'],
                            'address' => $fields['enterpriseAddress'],
                            'is_active' => $fields['isActive'],
                        ]);
            return response("Enterprise Updated", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showAllEnterprises(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $enterprise = Enterprise::join('users','users.id','=','enterprises.agent_id')
                                ->orderBy('created_at', 'desc')
                                ->get(['enterprises.*','users.name']);
            return response($enterprise, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showEnterprise(Request $request, $enterprise_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0") || $auth->tokenCan("1")) {
            $enterprise = Enterprise::find($enterprise_id);
            $agent = $enterprise->users;
            $members = Enterprise::find($enterprise_id)->farmers;
            $plant_count = 0;
            $users = [];
            foreach ($members as $m) {
                $count = Farmer::find($m['id'])->plants->first();
                $user = Farmer::find($m['id'])->users;
                if ($count) {
                    $plant_count = $plant_count + $count['remain_plant'];
                    $remain = $count['remain_plant'];
                } else {
                    $plant_count = $plant_count + $m['received_amount'];
                    $remain = $m['received_amount']; 
                }
                $new_arr = [
                "id" => $m->id,
                "address" => $m->address,
                "area" => $m->area,
                "lat" => $m->lat,
                "long" => $m->long,
                "userid" => $user->id,
                "name" => $user->name,
                "tel" => $user->tel,
                "remain" => $remain,
                "created_at" => $user->created_at,
            ];
            array_push($users, $new_arr);

            }

            $data = [
                "enterprise" => $enterprise,
                "members" => $users,
                "memberAmount" => $members->count(),
                "plantAmount" => $plant_count,
                "agent" => $agent,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function enterpriseNumber(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $data = [
                'num' => Enterprise::all()->count(),
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }
}
