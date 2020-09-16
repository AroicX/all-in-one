<?php

namespace App\Http\Controllers\CorpPay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CorpPay\Bid;
use App\Model\CorpPay\BidItem;
use App\Model\CorpPay\PendingVendor;
use App\Model\CorpPay\Vendor;
use App\Http\Controllers\EmailController;
use App\Model\CorpPay\PriceQuote;
use Illuminate\Support\Facades\File;;
use Illuminate\Support\Facades\Response;

class VendorsController extends Controller
{
    //

    public function getPendingVendors($id)
    {
        $bid = Bid::where('bid_number', '=', $id)->first();
        $bid_items = BidItem::where('bid_number', '=', $id)->get();
        $p_vendors = PendingVendor::where('bid_number', '=', $id)->get();

        return view('CorpPay.pending_vendors', compact('p_vendors', 'bid', 'bid_items'));

    }

    public function addVendor(Request $request)
    {
        $id = $request->id;
        $p_vendor = PendingVendor::where('id', '=', $id)->first();

        //sstore the retrieved data in the real vendors table after verigication 
        $vendor = new Vendor();
        $vendor->bid_number = $p_vendor->bid_number;
        $vendor->company_name = $p_vendor->company_name;
        $vendor->name = $p_vendor->name;
        $vendor->title = $p_vendor->title;
        $vendor->address = $p_vendor->address;
        $vendor->city = $p_vendor->city;
        $vendor->state = $p_vendor->state;
        $vendor->zip = $p_vendor->zip;
        $vendor->phone = $p_vendor->phone;
        $vendor->fax = $p_vendor->fax;
        $vendor->email = $p_vendor->email;
        $vendor->business_des = $p_vendor->business_des;
        $vendor->bids_quote = serialize($p_vendor->bids_quote);
        $vendor->save();

        //delete the vendor from the pending_vendors table
        PendingVendor::where('id', '=', $id)->delete();

        return "success";
    }

    public function getNewVendor()
    {
        return view('CorpPay.add_vendor');
    }

    public function addNewVendor(Request $request)
    {
        $this->validate(
            $request, [
            'bid_number' => 'required|numeric',
            'company_name' => 'required',
            'name' => 'required',
            'title' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'telephone' => 'required|numeric',
            'fax' => 'required|numeric',
            'email' => 'required|email',
            'business' => 'required'
            ]
        );

        $vendor = new Vendor();
        $vendor->bid_number = $request->bid_number;
        $vendor->company_name = $request->company_name;
        $vendor->name = $request->name;
        $vendor->title = $request->title;
        $vendor->address = $request->address;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->zip = $request->zip;
        $vendor->phone = $request->telephone;
        $vendor->fax = $request->fax;
        $vendor->email = $request->email;
        $vendor->business_des = $request->business;
       
        $vendor->save();
        $success = true;
        return view('CorpPay.add_vendor', compact('success'));
    }

    public function listVendors($action)
    {
        if($action === "price_quote") {
            $vendors = Vendor::get();
            $type = $action;
           
            return view('CorpPay.list_vendors', compact('vendors', 'type'));
        }
        elseif($action === "purchase_order") {
            $vendors = PriceQuote::where('status', 'accepted')->get();
            $type = $action;
           
            return view('CorpPay.purchase_order_list', compact('vendors', 'type'));
        }
        elseif($action === "invoice") {
            $vendors = PriceQuote::where('status', 'accepted')->get();
            $type = $action;
           
            return view('CorpPay.purchase_order_list', compact('vendors', 'type'));
        }
        else{
            return "Error!!! this link does not exist";
        }
        
    }

    public function sendMail(Request $request)
    {

        $vendor = Vendor::where('id', $request->id)->first();
        $to = $vendor->email;
        $type = $request->type;
        $mailer = new EmailController();
        $value = $mailer->sendMail($type, $to);
        
        return "Mail sent";
    }

    public function managePriceQuote()
    {
        //call the price_quote collection
        $quotes = PriceQuote::get();

        return view('CorpPay.manage_price_quote', compact('quotes'));
    }

    public function viewDoc()
    {
        //get the file_name from the url {} option and insert in the storage_path() below.
        $file = storage_path('/file/TARGET_WORKERS.pdf');
        if(File::isFile($file)) {
            $file = File::get($file);
            $response = Response::make($file, 200);

            $response->header('Content-type', 'application/pdf');

            return $response;
        }
    }

    public function priceQuoteStatus(Request $request)
    {
        $quote = PriceQuote::where('id', $request->id)->first();
        $quote->status = $request->type;
        $quote->save();

        return "success";
    }
 
}
