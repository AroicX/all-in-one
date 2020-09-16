<?php

namespace App\Http\Controllers\CorpPay;

use Illuminate\Http\Request;
use App\Model\CorpPay\Bid;
use App\Model\CorpPay\BidItem;
use App\Model\CorpPay\PendingVendor;
use App\Http\Controllers\Controller;

class CorpPayController extends Controller
{
    public function viewDashboard()
    {
        return view('CorpPay.index');
    }

    public function viewCreateBid()
    {

        $bid_no = rand(1, 10000000);
        return view('CorpPay.create_bid', compact('bid_no'));
    }

    public function getBidInfo(Request $request)
    {
        $request->all();
        $bid = new Bid();
        $bid->bid_number = $request->bid_number;
        $bid->bid_opening_date = $request->bid_opening_date;
        $bid->bid_opening_time = $request->bid_opening_time;
        $bid->name = $request->name;
        $bid->phone = $request->phone;
        $bid->email = $request->email;
        $bid->commodity_desc = $request->commodity_desc;
        $bid->fax = $request->fax;
        $bid->contract_type = $request->contract_type;
        $bid->scope = $request->scope;
        
        $bid->save();
        $bid_no = rand(1, 10000000);
        $success = 'success';
        return $success;
    }

    public function addBidItem(Request $request)
    {

        $bid_item = new BidItem();
        $bid_item->bid_number = $request->bid_number;
        $bid_item->item_name = $request->item_name;
        $bid_item->item_brand = $request->item_brand;
        $bid_item->item_quantity = $request->item_quantity;

        $bid_item->save();
        $response = "success";
        return $response;
    }

    public function viewVendorBidRequest($id)
    {
        $bid = Bid::where('bid_number', '=', $id)->first();
        $bid_items = BidItem::where('bid_number', '=', $id)->get();
        //$customer_no = rand(1,1000000);

        //return $bid_items;
        return view('CorpPay.external.vendor', compact('bid', 'bid_items'));
    }

    public function addVendor(Request $request)
    {
        $vendor = new PendingVendor();
        $vendor->bid_number = $request->formData[0];
        $vendor->company_name = $request->formData[1];
        $vendor->name = $request->formData[2];
        $vendor->title = $request->formData[3];
        $vendor->address = $request->formData[4];
        $vendor->city = $request->formData[5];
        $vendor->state = $request->formData[6];
        $vendor->zip = $request->formData[7];
        $vendor->phone = $request->formData[8];
        $vendor->fax = $request->formData[9];
        $vendor->email = $request->formData[10];
        $vendor->business_des = $request->formData[11];
        $vendor->bids_quote = serialize($request->bidArray);
        $vendor->save();

        return "success";
    }

    public function getBids()
    {
        $bid = new Bid();
        $bids = $bid->all();
        return view('CorpPay.manage_bid', compact('bids'));
    }

    public function updateBids($id)
    {
        $bid = Bid::where('bid_number', '=', $id)->first();
        $bid_items = BidItem::where('bid_number', '=', $id)->get();

        return view('CorpPay.update_bid', compact('bid', 'bid_items'));
    }

    public function deleteBidItem(Request $request)
    {
        $id = $request->id;
        BidItem::find($id)->delete();
        return "deleted";
    }

    public function getBidItems(Request $request)
    {
        $id = $request->bid_number;
        $bid_items = BidItem::where('bid_number', '=', $id)->get();
        $bid_items = json_encode($bid_items);

        return $bid_items;
    }
}
