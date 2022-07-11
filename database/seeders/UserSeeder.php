<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getDate = date("Y-m-d");

        $users=[];

        for($i=1;$i<40;$i++){
            $user = [
                'email' => "user$i@gmail.com",
                'user_name' => "user $i",
                'birthday' => "$getDate",
                'first_name' => "Cao",
                'last_name' =>  "Hải",
                'password' =>  Hash::make("123456"),
                'status' => $i
            ];

            array_push($users, $user);
        }

        foreach($users as $key => $value){
            User::create($value);
        }
    }
}
