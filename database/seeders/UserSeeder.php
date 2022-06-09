<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $data = [
            [
                "name"=> "Naphat Keawpibal",
                'password' => Hash::make('067493442'),
                'tel' => "0887607910",
                'role' => 0, // admin
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "name"=> "uriawan",
                'password' => Hash::make('Uriawan1973'),
                'tel' => "0980611591",
                'role' => 0, // admin
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     "name"=> "นายประสิทธิ์ ดีพร้อม",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0892222222",
            //     'role' => 1, // enterprise
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     "name"=> "นางสมบูรณ์ ผิวขาว",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0893333333",
            //     'role' => 1, // enterprise
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     "name"=> "นายสมนึก สุดใจ",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0894444444",
            //     'role' => 1, // farmer
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     "name"=> "นางแก้วตา ใจดี",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0895555555",
            //     'role' => 2, // farmer
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     "name"=> "นายสมศักดิ์ รักยิ่ง",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0896666666",
            //     'role' => 2, // farmer
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     "name"=> "นายจักร คงทน",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0897777777",
            //     'role' => 2, // farmer
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     "name"=> "นางปรียา รักสวย",
            //     'password' => Hash::make('123456'),
            //     'tel' => "0898888888",
            //     'role' => 2, // farmer
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
        ];

        DB::table('users')->insert($data);
    }
}
