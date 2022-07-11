<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public static function delete($id)
    {
        $product = Product::find($id);
        $product->flag_delete = 1 ;
        $product->save();
        return response()->json();
    }

    
}
