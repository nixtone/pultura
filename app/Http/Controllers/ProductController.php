<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function list() {
        $productList = Product::all();
        return view('product.list', compact('productList'));
    }

    public function item(Product $product) {
        return view('product.item', compact('product'));
    }

    public function create() {
        return view('product.create');
    }
}
