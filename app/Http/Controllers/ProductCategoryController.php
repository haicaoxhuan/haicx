<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductCategory\CreateRequest;
use App\Http\Requests\ProductCategory\UpdateRequest;
use App\Services\CategorySevice;

class ProductCategoryController extends Controller
{
    protected $category;

    public function __construct(CategorySevice $categoryService)
    {
        $this->middleware('auth:admin');
        $this->category = $categoryService;
    }

    /**
     * show list category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products_category = ProductCategory::select(
            "products_category.*",
            "users.id as user_id",
        )
            
            ->join("users", "users.id", "=", "products_category.user_id")
            ->paginate(PAGE_RECORDS);
        return view('user.index', [
            'products_category' => $products_category
        ]);
    }

    /**
     * create new category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $list_category = ProductCategory::select('id', 'name', 'parent_id')
            ->where('parent_id', '=', null)
            ->get();
        return view('user.create', [
            'list_category' => $list_category
        ]);
    }

    /**
     * save new category
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        $issua = ProductCategory::find($request->parent_id);
        $data = new ProductCategory();
        $data->user_id = Auth::id();
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->save();
        return redirect()->route('home')->with('success', 'Thêm  thành công');
    }

    /**
     * edit category
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $products_category = ProductCategory::select('id', 'name', 'parent_id')
            ->orderByDesc('id')
            ->where('id', '=', $id)
            ->first();

        if ($products_category) {
            $list_category = ProductCategory::select('id', 'name', 'parent_id')
                ->where('parent_id', '=', null)
                ->get();
            return view('user.update', [
                'product_category' => $products_category,
                'list_category' => $list_category
            ]);
        } else {
            return redirect()->route('home')->with('error', 'Lỗi');
        }
    }

    /**
     * update category
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {

        try {
            $data = ProductCategory::find($request->id);
            if ($data) {
                $data->name = $request->name;
                $data->parent_id = $request->parent_id;
                $data->user_id = Auth::id();
                $data->save();
            } else {
                return redirect()->with('error');
            };


            return redirect()->route('home')->with('success', 'Sửa  thành công');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Sửa  thất bại');
        }
    }



    /**
     * delete category
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        return $this->category->delete($request->id);
    }
}
