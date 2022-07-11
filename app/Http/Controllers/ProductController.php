<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \PDF;
use \Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\ProductExport;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Services\ProductService;
use App\Services\UploadService;

class ProductController extends Controller
{
    protected $productdlt;
    protected $productupl;

    public function __construct(ProductService $productService, UploadService $uploadService)
    {
       
        $this->productdlt = $productService;
        $this->productupl = $uploadService;
    }

    /**
     * show list of product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->key;
        $stock = (int)$request->stock;

        $products = Product::select(
            "product.id",
            "product.sku",
            "product.name",
            "product.stock",
            "product.avatar",
            "product.category_id",
            "product.expired_at",
            "users.id as user_id",
            "products_category.name as category_name"
        )
            ->join("users", "users.id", "=", "product.user_id")
            ->join("products_category", "products_category.id", "=", "product.category_id")
            ->where('product.flag_delete', 0 )
            ->where(function ($q) use ($keyword) {
                $q->orwhere('product.name', 'like', '%' . $keyword . '%');
                $q->orWhere('products_category.name', 'like', '%' . $keyword . '%');
            });

        switch ($stock) {
            case 1:
                $products->whereBetween('product.stock', [0, 10]);
                break;

            case 2:
                $products->whereBetween('product.stock', [10, 100]);
                break;
            case 3:
                $products->whereBetween('product.stock', [100, 200]);
                break;
            case 4:
                $products->whereBetween('product.stock', [200, 1000]);
                break;
            case 0:
            default:
        };
        $products = $products->paginate(PAGE_RECORDS);
        return view('user.product.index', [
            'products' => $products
        ]);
    }

    /**
     * create new product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $list_category = ProductCategory::select('id')
            ->get();
        return view('user.product.create', [
            'list_category' => $list_category
        ]);
    }

    /**
     * save new product
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(CreateRequest $request)
    {

        $issue = new Product();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $issue->avatar = $this->productupl->store($file);

        } else {
            $issue->avatar = "";
        }
        try {
            $issue->user_id = Auth::id();
            $issue->category_id = $request->id;
            $issue->name = $request->name;
            $issue->sku = $request->sku;
            $issue->stock = $request->stock;
            $issue->expired_at = $request->expired_at;
            $issue->flag_delete = STATUS_DELETE;
            $issue->save();
            return redirect()->route('product-list')->with('success', 'Thêm  thành công');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * edit product
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $product = Product::select('id', 'sku', 'name', 'avatar', 'stock', 'expired_at', 'category_id')
            ->where('id', '=', $id)
            ->get();
        if ($product) {
            $list_category = ProductCategory::select('id')
                ->get();
            return view('user/product/update', [
                'products' => $product,
                'list_category' => $list_category
            ]);
        } else {
            return redirect()->with('error', 'thất bại');
        };
    }

    /**
     * update product
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        try {
            $data = Product::find($request->id);
            
            if ($data) {
                $data->user_id = Auth::id();
                $data->category_id = $request->category_id;
                $data->name = $request->name;
                $data->sku = $request->sku;
                $data->stock = $request->stock;
                $data->expired_at = $request->expired_at;
                $data->flag_delete = STATUS_DELETE;

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $data->avatar = $this->productupl->store($file);
                } 
                
                $data->save();
            } else {
                return redirect()->with('error');
            };

            return redirect()->route('product-list')->with('success', '  thành công');
        } catch (\Exception $e) {
            return redirect()->route('product-list')->with('error', '  thất bại');
        }
    }

    /**
     * delete product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        return $this->productdlt->delete($request->id);

    }

    /**
     * downloadPDF list product
     * @return mixed
     */
    public function downloadPdf()
    {
        $products = Product::select(
            "product.id",
            "product.name",
            "product.stock",
            "product.expired_at",
            "products_category.name as category_name",
        )
            ->join("products_category", "products_category.id", "=", "product.category_id")
            ->get();
        $data = [
            'title' => 'DANH SACH SAN PHAM',
            'date' => date('m/d/Y')
        ];


        $pdf = PDF::loadView('user.product.productpdf', [
            'products' => $products,
            'data' => $data,

        ]);
        return $pdf->download('productpdf.pdf');
    }

    /**
     * downloadCSV list product
     * @return mixed
     */
    public function export()
    {
        return Excel::download(new ProductExport, 'disney.csv');
    }

    
}
