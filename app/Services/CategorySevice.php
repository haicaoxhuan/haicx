<?php

namespace App\Services;

use App\Models\ProductCategory;

class CategorySevice
{
    public static function delete($id)
    {
        $products_category = ProductCategory::find($id);
        $products_category->flag_delete = 1 ;
        $products_category->save();
        return response()->json();
    }
}
