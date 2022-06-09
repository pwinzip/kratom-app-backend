<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function addNewSale(Request $request, $enterprise_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("1")) {
            $fields = $request->validate([
                'saleDate' => 'required|string',
                'saleAmount' => 'required|numeric',
            ]);
            $sale = Sale::create([
                'enterprise_id' => $enterprise_id,
                'date_for_sale' => Carbon::createFromFormat('d/m/Y', $fields['saleDate'])->format('Y-m-d'),
                'quantity_for_sale' => $fields['saleAmount'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response("New Sale Added", 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showSalesByEnterprise(Request $request, $enterprise_id) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0") || $auth->tokenCan("1")) {
            $sales = Enterprise::find($enterprise_id)->sales;
            $enterprise = Enterprise::find($enterprise_id);
            $agent = User::find($enterprise['agent_id']);
            $data = [
                "enterprise" => $enterprise,
                "agent" => $agent,
                "sale" => $sales,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    public function showAllSales(Request $request) {
        // $auth = $request->user();
        // if ($auth->tokenCan("0")) {
            $sales = Sale::all()->enterprises;
            $data = [
                "payload" => $sales,
            ];
            return response($data, 200);
        // } else {
        //     return response('Permission Denied.', 403);
        // }
    }

    
}
