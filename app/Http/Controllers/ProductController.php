<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $filePath = "/public/product/";

    public function list() {
        $productList = Product::all();
        return view('product.list', compact('productList'));
    }

    public function item(Product $product) {
        return view('product.item', compact('product'));
    }

    public function create(Category $category)
    {
        $categoryList = Category::all();
        return view('product.create', compact('categoryList', 'category'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $newItem = Product::create($data);
        if($request->hasFile('files')) {
            $newDir = $this->filePath.$newItem->id;
            $dir = Storage::makeDirectory($newDir);
            foreach($request->file('files') as $index => $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($newDir, $filename);
                $arFiles[] = $filename;
            }
        }
        return redirect()->route('catalog.category.item', $newItem->category_id);
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
        /*
        dd(Storage::url('static/images/second.jpg'));

        $catFolder = '/storage'.$this->upload_dir.Category::find($product->category_id)->translit;
        foreach(scandir($catFolder) as $file) {
            list($fname, $fext) = explode($file);
            if($fname == $product->id) {
                $productImage = $file;
                break;
            }
        }
        TODO: существует ли файл товара и удалить
        */
        dd($product);

        $product->delete();
        return redirect()->route('catalog.category.item', $product->category_id);
    }

}
