<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::get();
        return view('products',[
            'products'=> $products
        ]);
    }
    public function detail($id){
        $product = Product::with('attributes', 'images')->find($id);
        return view('product-detail',[
            'product'=> $product
        ]);
    }
}
