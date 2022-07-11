<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'user_id' => 1,
                'name' => "category 1",
                'parent_id' => 0,
            ],
            [
                'user_id' => 1,
                'name' => "category 2",
                'parent_id' => 1,
            ],
            [
                'user_id' => 2,
                'name' => "category 3",
                'parent_id' => 0,
            ],
        ];

        for($i=4;$i<25;$i++){
            $category = [
                'user_id' => $i,
                'name' => "category $i",
                'parent_id' => 0,
            ];

            array_push($categories, $category);
        }

        foreach($categories as $key => $value){
            ProductCategory::create($value);
        }
    }
}
