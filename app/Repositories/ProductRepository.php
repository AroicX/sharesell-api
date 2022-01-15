<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;

use App\Products;
// use Auth;

// use App\User;
use Illuminate\Http\Request;

class ProductRepository extends Controller implements ProductRepositoryInterface
{
    public function index()
    {
        try {
            $products = Products::where('status', 'available')
                ->with('category', 'user')
                ->paginate(50);
            return $products;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create(Request $request)
    {
        // TODO: Implement create() method.

        try {
            $product = new Products();

            $product->user_id = $request->user_id;
            $product->product_category = $request->product_category;
            $product->product_name = $request->product_name;
            $product->product_images = json_encode($request->product_images);
            $product->product_description = $request->product_description;
            $product->product_price = $request->product_price;
            $product->product_weight = $request->product_weight;
            $product->product_size = $request->product_size;
            $product->product_quantity = $request->product_quantity;
            $product->product_number = $request->product_number;
            $product->product_retail_price = $request->product_retail_price;
            $product->pickup_address = $request->pickup_address;
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
            $id = $request->product_id;

            $data = [
                'product_category' => $request->product_category,
                'product_name' => $request->product_name,
                'product_images' => $request->product_images,
                'product_description' => $request->product_description,
                'product_price' => $request->product_price,
                'product_weight' => $request->product_weight,
                'product_size' => $request->product_size,
                'product_quantity' => $request->product_quantity,
                'product_number' => $request->product_number,
                'product_retail_price' => $request->product_retail_price,
                'pickup_address' => $request->pickup_addreess,
                'state' => $request->state,
                'city' => $request->city,
            ];

            $product = Products::where('id', $id)->update($data);

            return $product;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($id)
    {
        try {
            return Products::where('id', $id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
