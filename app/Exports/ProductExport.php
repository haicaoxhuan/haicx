<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use \Excel;
class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Product::select(
            "product.id",
            "product.name",
            "product.stock",
            "product.expired_at",
            "products_category.name as category_name",
        )
            ->join("products_category", "products_category.id", "=", "product.category_id")->get();
    }
}
