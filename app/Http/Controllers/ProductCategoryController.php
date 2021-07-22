<?php

namespace App\Http\Controllers;

use App\ProductCategories;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    //

    public function index()
    {
        $categories = ProductCategories::all();

        // return $categories;

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
