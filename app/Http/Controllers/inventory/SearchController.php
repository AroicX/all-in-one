<?php

namespace App\Http\Controllers\inventory;

use Request;
use App\Http\Controllers\Controller;
use App\inventory\Product;
class SearchController extends Controller
{
    //

      public function productsearch(Request $request){
        $keyword = Request::get('q');
        $results = Product::where('barcode', 'like', "$keyword%")->orWhere('description', 'like' , "$keyword%")->get();
        return print_r(json_encode($results));die;
    }
}
