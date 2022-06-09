<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_details')->delete();

        $data = [
            [
                "order_id"=> 1,
                'type' => 'ใบ',
                'unit' => 'กิโลกรัม',
                'buy_amount' => 20,
                'buy_price' => 20,
                'date_preferred' => Carbon::now()->addDays(10)->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "order_id"=> 1,
                'type' => 'ผง',
                'unit' => 'กิโลกรัม',
                'buy_amount' => 20,
                'buy_price' => 10,
                'date_preferred' => Carbon::now()->addDays(10)->toDateString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('order_details')->insert($data);
    }
}
