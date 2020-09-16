<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\inventory\ProductLine;
use App\inventory\ProductLineItem;
use App\Company;
class ProductLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productlines = Company::find(Auth::user()->company_id)->product_line()->get();
        return view('inventory.productline.index' , compact('productlines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('inventory.productline.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $productline = new ProductLine($request->all());
        $productline->company_id = Auth::user()->company_id;
        $productline->save();
        return redirect(route('productline.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $productline = ProductLine::find($id);
        $productline_items = $productline->product_line_item()->get();
        $products = Auth::user()->product()->get();
        return view('inventory.productline.show', compact('productline', 'productline_items', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productline = ProductLine::find($id);
        return view('inventory.productline.edit', compact('productline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productline = ProductLine::find($id);
        $productline->update($request->all());
        return redirect(route('productline.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productline = ProductLine::find($id);
        $productline->delete();
        return redirect(route('productline.index'));
    }

    public function productline_item(Request $request){
        $productline_item = new ProductLineItem($request->all());
        $productline_item->save();
        return redirect(route('product.show', $request->product_id));
    }

    public function edit_product_line_item(Request $request, $id){
        dd($request->all());
        $pli = ProductLineItem::find($id);
        $pli->update($request->all());
        return redirect(route('product.show', $request->product_id));
    }
}
