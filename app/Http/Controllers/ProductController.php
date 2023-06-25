<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function list() {
        $productList = Product::all();
        return view('product.list', compact('productList'));
    }

    public function item(Product $product) {
        // return view('catalog.product.item', compact('product'));
    }

    public function create() {
        $categoryList = Category::all();
        return view('product.create', compact('categoryList'));
    }

    public function edit(Product $product) {
        $categoryList = Category::all();
        return view('product.edit', compact('product', 'categoryList'));
    }
}
