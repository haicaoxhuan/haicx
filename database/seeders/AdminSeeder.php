<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getDate = date("Y-m-d");
        $admins = [
            [
                'email' => "admin1@gmail.com",
                'user_name' => "admin 1",
                'birthday' => "$getDate",
                'first_name' => "Cao",
                'last_name' =>  "Hải",
                'password' =>  Hash::make("123456"),
                'status' => 1
            ],
            [
                'email' => "admin2@gmail.com",
                'user_name' => "admin 2",
                'birthday' => "$getDate",
                'first_name' => "Cao",
                'last_name' =>  "Hải",
                'password' =>  Hash::make("123456"),
                'status' => 1
            ],
            [
                'email' => "admin3@gmail.com",
                'user_name' => "admin 3",
                'birthday' => "$getDate",
                'first_name' => "Cao",
                'last_name' =>  "Hải",
                'password' =>  Hash::make("123456"),
                'status' => 1
            ],
        ];

        foreach($admins as $key => $value){
            Admin::create($value);
        }

    }
}
