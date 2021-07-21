<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Product;
use Auth;

use App\User;
use Illuminate\Http\Request;

class ProductRepository extends Controller implements ProductRepositoryInterface
{
    public function index()
    {
        try {
            $products = Product::where('status', 'available')
                ->with('category', 'user')
                ->get();
            return $products;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create(Request $request)
    {
        // TODO: Implement create() method.

        try {
            $product = new Product();

            $product->user_id = $request->user_id;
            $product->product_category = $request->product_category;
            $product->product_name = $request->product_name;
            $product->product_images = 'none';
            $product->product_description = $request->product_description;
            $product->product_price = $request->product_price;
            $product->product_weight = $request->product_weight;
            $product->product_size = $request->product_size;
            $product->product_quantity = $request->product_quantity;
            $product->product_number = $request->product_number;
            $product->product_retail_price = $request->product_retail_price;
            $product->pickup_addreess = $request->pickup_addreess;
            $product->state = $request->state;
            $product->city = $request->city;

            $product->save();

            return $product;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request)
    {
        //TODO:
        try {
            // $products = Product::where('status', 'available')
            //     ->with('category', 'user')
            //     ->get();
            // return $products;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($id)
    {
        try {
            return Product::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
