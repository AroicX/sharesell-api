<?php

namespace App\Http\Controllers;

use App\ProductCategories;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    //

    public function api()
    {
        $categories = ProductCategories::paginate(10);
        return $this->jsonFormat(
            200,
            'success',
            count($categories) . ' categories found',
            $categories
        );
    }

    public function getCategoryProducts($category_id = null)
    {
        $categories = ProductCategories::where('category_id', $category_id)
            ->with('products')
            ->paginate(50);

        if (!$categories) {
            return $this->jsonFormat(404, 'error', 'Category not found', null);
        }
        return $this->jsonFormat(200, 'success', 'Products found', $categories);
    }

    public function index()
    {
        $categories = ProductCategories::all();

        return view('admin.products.category', ['categories' => $categories]);
    }

    public function create(Request $request)
    {
        // return $request->all();
        try {
            $category = new ProductCategories();
            $category->category_id = sprintf('%06d', mt_rand(1, 999999));
            $category->category_name = $request->category_name;
            $category->category_type = $request->category_type;
            $category->save();

            $response = [
                'message' => 'Category added successfully.🙂',
                'alert' => 'success',
            ];

            return redirect()
                ->back()
                ->with($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
