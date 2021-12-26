<?php

namespace App\Http\Controllers;

use App\User;
use App\Products;
use App\ProductCategories;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
        // $this->middleware('protected.auth');
    }

    public function searchProducts($name = null)
    {
        $products = Products::where('product_name', 'LIKE', "%{$name}%")->get();

        return $this->jsonFormat(
            200,
            'success',
            count($products) . ' products found.',
            $products
        );
    }

    public function dashboard()
    {
        $products = Products::with('category', 'user')->get();

        // dd($products);

        return view('admin.products.index', ['products' => $products]);
    }

    public function index()
    {
        $products = $this->productRepository->index();

        return $this->jsonFormat(
            200,
            'success',
            count($products) >= 2 ? ' products found.' : 'product found',
            $products
        );
    }
    public function getRecentProducts()
    {
        $products = Products::latest()
            ->with('category', 'user')
            ->take(6)
            ->get();

        $length = count($products);

        return $this->jsonFormat(
            200,
            'success',
            $length >= 2
                ? $length . ' products found.'
                : $length . ' product found',
            $products
        );
    }

    public function create(Request $request)
    {
        $this->validateParameter('user_id', $request->user_id, INTEGER, true);
        $this->validateParameter(
            'product_category',
            $request->product_category,
            INTEGER,
            true
        );
        $this->validateParameter(
            'product_name',
            $request->product_name,
            STRING,
            true
        );
        $this->validateParameter(
            'product_description',
            $request->product_description,
            STRING,
            true
        );
        $this->validateParameter(
            'product_price',
            $request->product_price,
            INTEGER,
            true
        );
        $this->validateParameter(
            'product_weight',
            $request->product_weight,
            INTEGER,
            true
        );
        $this->validateParameter(
            'product_size',
            $request->product_size,
            STRING,
            true
        );
        $this->validateParameter(
            'product_quantity',
            $request->product_quantity,
            STRING,
            true
        );
        $this->validateParameter(
            'product_number',
            $request->product_number,
            INTEGER,
            true
        );
        $this->validateParameter(
            'product_retail_price',
            $request->product_retail_price,
            INTEGER,
            true
        );
        $this->validateParameter(
            'pickup_address',
            $request->pickup_address,
            STRING,
            true
        );
        $this->validateParameter(
            'product_images',
            $request->product_images,
            STRING,
            true
        );
        $this->validateParameter('state', $request->state, STRING, true);
        $this->validateParameter('city', $request->city, STRING, true);

        if (!User::where('user_id', $request->user_id)->first()) {
            return $this->jsonFormat(
                400,
                'error',
                'Account with id ' . $request->user_id . ' not found.',
                null
            );
        }
        if (
            !ProductCategories::where(
                'category_id',
                $request->product_category
            )->first()
        ) {
            return $this->jsonFormat(
                400,
                'error',
                'Proudct with id ' . $request->product_category . ' not found.',
                null
            );
        }

        $products = $this->productRepository->create($request);
        return $this->jsonFormat(
            200,
            'success',
            'Create Product Successfully',
            $products
        );
    }

    public function uploadImages(Request $request, $product_id = null)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg|max:1048|required',
            ]);

            $image_name = $request->file('image')->getRealPath();
            //the upload method handles the uploading of the file and can accept attributes to define what should happen to the image

            $uploadedFileUrl = Cloudinary::uploadFile(
                $request->file('image')->getRealPath()
            )->getSecurePath();
            return $uploadedFileUrl;
        } else {
            return $this->jsonFormat(500, 'error', 'An error occurred!');
        }
    }

    public function update(Request $request)
    {
        $getProduct = Products::where('id', $request->product_id)
            ->with('category', 'user')
            ->first();

        if (!$getProduct) {
            return $this->jsonFormat(
                404,
                'error',
                'Product with id ' . $request->product_id . ' not found.',
                null
            );
        }

        $p = $this->productRepository->update($request);

        return $this->jsonFormat(
            200,
            'success',
            'Updated Product Successfully',
            Products::where('id', $request->product_id)
                ->with('category', 'user')
                ->first()
        );
    }

    public function delete($id = null)
    {
        $product = $this->productRepository->delete($id);

        if (!$product) {
            return $this->jsonFormat(
                400,
                'error',
                'Proudct with id ' . $id . ' not found.',
                null
            );
        }

        return $this->jsonFormat(
            200,
            'success',
            'Product has been deleted.',
            null
        );
    }
}
