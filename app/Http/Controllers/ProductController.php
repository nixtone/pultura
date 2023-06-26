<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function list() {
        $productList = Product::all();
        return view('product.list', compact('productList'));
    }

    public function item(Product $product) {
        // return view('catalog.product.item', compact('product'));
    }

    public function create(Category $category) {
        $categoryList = Category::all();
        return view('product.create', compact('categoryList', 'category'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $newProduct = Product::create($data);
        return redirect()->route('catalog.category.item', $newProduct->category_id);
    }

    public function edit(Product $product) {
        $categoryList = Category::all();
        return view('product.edit', compact('product', 'categoryList'));
    }

    public function update(ProductRequest $request, Product $product) {
        $data = $request->validated();
        $product->update($data);
        //dd($product->category->id);
        return redirect()->route('catalog.category.item', $product->category->id);
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('catalog.category.item', $product->category_id);
    }
}
