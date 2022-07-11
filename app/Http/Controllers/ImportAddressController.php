<?php

namespace App\Http\Controllers;

use App\Models\Province;

class ImportAddressController extends Controller
{

    /**
     * Insert data address to database.
     *
     * @return void
     */
    public function index()
    {
        try {

            // get data address from https://provinces.open-api.vn
            $data_array = json_decode(file_get_contents('https://provinces.open-api.vn/api/?depth=3'), true);

            foreach ($data_array as $province){
                // add province to database
                $province_item = Province::create([
                    'name' => $province['name'],
                    ]
                );

                // add districts for province
                foreach ($province['districts'] as $district){
                    $district_item = $province_item->districts()->create([
                        'name' => $district['name']
                        ]);

                    // add communes for district
                    foreach ($district['wards'] as $commune){
                        $district_item->communes()->create([
                            'name' => $commune['name'],
                        ]);
                    }

                }
            }

        } catch (\Exception $e) {
            report($e);
        }

    }
}
