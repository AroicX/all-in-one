<?php

namespace App\Http\Controllers\CorpFIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CorpFIN\CorpFinInvoiceItem;
use App\CorpFinProduct;
use App\CorpFinService;
use App\Http\Controllers\Invoice\InvoiceController;

class CorpFinInvoiceItemController extends Controller
{
    public $invCtrl;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // return 'gr';
        $data = $request->all();
        $array = [];
        foreach ($data['items'] as $item) {
            if($item['type'] === 'vat')
            {
                if(!CorpFinInvoiceItem::where('invoice_id', $data['invoice_id'])->exists())
                {
                    return response(['status' => 'error', 'msg' => 'You dont have any item in this invoice, please add invoice items before adding tax']);
                }

                if(!empty($item['vat_percent']) && $item['vat_percent'] > 0)
                {
                    $product_service_item_total = self::get_inv_product_service_item_total($data['invoice_id']);
                    $inv_vat = self::calculate_percentage($item['vat_percent'], $product_service_item_total); 
                }
                if(!empty($item['vat_amount'])  && $item['vat_amount'] > 0)
                {
                    $inv_vat = $item['vat_amount']; 
                }
                $data = [
                    "invoice_id" => $data['invoice_id'],
                    "total" => $inv_vat,
                    "description" => $item['name'],
                    "type" => $item['type']
                ];
                // return $data;
            }else
            {
                if($item['type'] === 'product')
                {
                    $quote_item = CorpFinProduct::find($item['id']);
                }
                if($item['type'] === 'service')
                {
                    $quote_item = CorpFinService::find($item['id']);
                }
                $total_amount = $quote_item->price * (int)$item['qty'];
                if($item['discount_percent'] > 0)
                {
                  $total_amount = $total_amount - self::calculate_percentage($item['discount_percent'], $total_amount);
                }
                $total_vat = $quote_item->vat * (float)$item['qty'];
                $data = [
                    "invoice_id" => $data['invoice_id'],
                    "item_id" => $item['id'],
                    "quantity" => $item['qty'],
                    "vat" => $total_vat,
                    "sub_total" => $total_amount,
                    "total" => $total_amount + $total_vat,
                    "discount_percent" => $item['discount_percent'] ?? 0,
                    "discount_amount" => $item['discount_amount'] ?? 0,
                    "type" => $item['type']
                ];
            }
            $store = self::store($data);
            array_push($array, $store);
        }
        $invCtrl = new InvoiceController;
        $invCtrl->store_cart($data['invoice_id']);
        return response(['status' => 'ok', 'data' => $array, 'msg' => 'Qoute Items Added']);
    }

    //edit the invoice product quantity
    public function edit_item(Request $request){
        $update_item = CorpFinInvoiceItem::find($request->rowId);
        $item = [];
        if($update_item->type === 'product')
        {
            $item = CorpFinProduct::find($update_item['item_id']);
        }
        if($update_item->type === 'service')
        {
            $item = CorpFinService::find($update_item['item_id']);
        }
        $total_amount = $item->price * (double)$request->quantity;
        if($update_item->discount_percent > 0)
        {
          $total_amount = $total_amount - self::calculate_percentage($update_item->discount_percent, $total_amount);
        }
        $total_vat = $item->vat * $request->quantity;
        $update_item->quantity = $request->quantity;
        $update_item->vat = $total_vat;
        $update_item->sub_total = $total_amount;
        $update_item->total = $total_amount + $total_vat;
        $update_item->save();
        //Cart::instance($request->invoice_id)->update($request->rowId, $request->quantity);
        $invCtrl = new InvoiceController;
        return $invCtrl->store_cart($request->invoice_id);        
    }

    /**
    *@method get_inv_item_total
    *
    */
    public static function get_inv_product_service_item_total($invoice_id)
    {
        $total = 0;
        $inv_items = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->get();
        foreach ($inv_items as $inv_item) {
            if($inv_item->type != 'vat')
            {
                if($inv_item->type === 'product')
                {
                    $item = CorpFinProduct::find($inv_item['item_id']);
                }
                if($inv_item->type === 'service')
                {
                    $item = CorpFinService::find($inv_item['item_id']);
                }
                $total += $item->price;
            }
        }
        return $total;
    }

    /**
    *@method get_inv_item_total
    *
    */
    public static function get_items_vat_total($invoice_id)
    {
        $total = 0;
        $inv_items = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->get();
        foreach ($inv_items as $inv_item) {
            if($inv_item->type != 'vat')
            {
                if($inv_item->type === 'product')
                {
                    $item = CorpFinProduct::find($inv_item['item_id']);
                }
                if($inv_item->type === 'service')
                {
                    $item = CorpFinService::find($inv_item['item_id']);
                }
                $total_vat = $item->vat * $inv_item->quantity;
                $total += $total_vat;
            }
        }
        return $total;
    }
    /**
    *@method get_inv_item_total
    *
    */
    public static function get_inv_item_vat_total($invoice_id)
    {
        return $total_vat = CorpFinInvoiceItem::where('invoice_id', $invoice_id)->where('type', 'vat')->sum('total');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data)
    {
        $store = CorpFinInvoiceItem::create($data);
        return $store;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_items_by_qoute(int $qoute_id)
    {
        $qoutes_items = CorpFinInvoiceItem::where('id', $qoute_id)->get();
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @method calculate_percentage
     *
     */
    public static function calculate_percentage($percent, $amount){
        return ($percent/100) * $amount;
    }
}
