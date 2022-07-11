<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::truncate();
  
        $json = File::get("database/data/quan_huyen.json");
        $districts = json_decode($json);
  
        foreach ($districts as $key => $value) {
            District::create([
                "id" => $value->code,
                "name" => $value->name,
                "province_id" => $value->province_id,
            ]);
        }
    }
}
