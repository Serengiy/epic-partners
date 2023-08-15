<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\StoreRequest;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $filter = new ProductFilter($request->all());
        $products = Product::filter($filter)->get();
        $categories = Category::all();
        return inertia('Home', compact('products', 'categories'));
    }

    public function store(StoreRequest $request)
    {
        $data=$request->validated();
        $categories = $data['categories'];
        unset($data['categories']);
        $product = Product::create($data);

        $categories = Category::whereIn('title', $categories)->get();
        foreach ($categories as $category){
            CategoryProduct::create([
                'product_id' => $product->id,
                'category_id' => $category->id
            ]);
        }
        return redirect()->back();
    }
}
