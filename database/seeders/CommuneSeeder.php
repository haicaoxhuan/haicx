<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Commune::truncate();
  
        $json = File::get("database/data/xa_phuong.json");
        $communes = json_decode($json);
  
        foreach ($communes as $key => $value) {
            Commune::create([
                "id" => $value->code,
                "name" => $value->name,
                "district_id" => $value->district_id,
            ]);
        }
    }
}
