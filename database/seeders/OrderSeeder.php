<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->delete();

        $data = [
            [
                "order_no"=> 'ax123',
                'customer_name' => 'ping',
                'company' => 'pingcom',
                'address' => 'hatyai',
                'tel' => '123456789',
                'total_price' => 600,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('orders')->insert($data);
    }
}
