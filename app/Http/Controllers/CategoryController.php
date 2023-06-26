<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function list() {
        $categoryList = Category::all(); // whereNull('parent_id')->get();
        return view('category.list', compact('categoryList'));
    }

    public function item(Category $category) {
        return view('category.item', compact('category'));
    }

    public function create() {
        $categoryList = Category::all();
        return view('category.create', compact('categoryList'));
    }
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $newCategory = Category::create($data);
        return redirect()->route('catalog.category.item', $newCategory->id);
    }

    public function edit(Category $category) {
        $categoryList = Category::all();
        return view('category.edit', compact('category', 'categoryList'));
    }

    public function update(CategoryRequest $request, Category $category) {
        $data = $request->validated();
        $category->update($data);
        return redirect()->route('catalog.category.item', $category->id);
    }

    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('catalog.category.list');
    }
}
