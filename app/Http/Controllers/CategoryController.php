<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function list() {
        $catList = Category::all();//whereNull('parent_id')->get();
        return view('category.list', compact('catList'));
    }

    public function item(Category $category) {
        $productList = Product::where('category_id', $category->id)->get();
        return view('category.item', compact('category', 'productList'));
    }

    public function create() {
        $categoryList = Category::all();
        return view('category.create', compact('categoryList'));
    }

    public function edit(Category $category) {
        $categoryList = Category::all();
        return view('category.edit', compact('category', 'categoryList'));
    }
}
