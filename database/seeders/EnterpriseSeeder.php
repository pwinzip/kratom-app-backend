<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enterprises')->delete();

        $data = [
            [
                "regist_no"=> "PHL001",
                'enterprise_name' => 'วิสาหกิจชุมชนกระท่อมเพื่อสุขภาพ',
                'agent_id' => 3,
                'address' => "พัทลุง",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "regist_no"=> "PHL002",
                'enterprise_name' => 'วิสาหกิจชุมชนกระท่อมสมุนไพร',
                'agent_id' => 4,
                'address' => "พัทลุง",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "regist_no"=> "PHL003",
                'enterprise_name' => 'วิสาหกิจชุมชนกระท่อมพาณิชย์',
                'agent_id' => 5,
                'address' => "พัทลุง",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('enterprises')->insert($data);
    }
}
