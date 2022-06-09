<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('farmers')->delete();

        $data = [
            [
                "user_id"=> 6,
                'address' => '111 ต.ชะมวง อ.ควนขนุน จ.พัทลุง',
                'area' => 1,
                'lat' => 7.556450,
                'long' => 100.413495,
                'received_amount' => 50,
                'enterprise_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "user_id"=> 7,
                'address' => '222 ต.บ้านพร้าว อ.ป่าพะยอม จ.พัทลุง',
                'area' => 20,
                'lat' => 7.556450,
                'long' => 100.413495,
                'received_amount' => 200,
                'enterprise_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "user_id"=> 8,
                'address' => '333 ต.ควนขนุน อ.ควนขุน จ.พัทลุง',
                'area' => 20,
                'lat' => 7.556450,
                'long' => 100.413495,
                'received_amount' => 150,
                'enterprise_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "user_id"=> 9,
                'address' => '444 ต.ลานข่อย อ.ป่าพะยอม จ.พัทลุง',
                'area' => 5,
                'lat' => 7.556450,
                'long' => 100.413495,
                'received_amount' => 100,
                'enterprise_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('farmers')->insert($data);
    }
}
