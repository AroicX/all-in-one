<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/23/16
 * Time: 5:03 PM
 */

namespace App\Http\Controllers\CorpTax;

use App\Models\CorpTax\VATMock;
use App\Model\CorpTax\SalesMock;
use App\Model\CorpTax\PurchaseMock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\CorpTax\TaxMivp;
use Illuminate\Support\Facades\Auth;
use App\Traits\SubscriptionTrait;

class VATController extends CorpTaxController
{
    use SubscriptionTrait;

    /**
     * @return mixed
     */
    public function getMonthlyVatReturn()
    {
        if (Auth::check()) {
            $query = view('CorpTax.MonthlyVatReturn');
        return $this->is_corptax_user_set($query);
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    
    public function postMonthlyVatReturn(Request $request)
    {
        if (Auth::check()) {

            $vatMock = new VATMock();
            $vatMock->tax_period = $request->tax_period;
            $vatMock->start_of_month = $request->start_of_month;
            $vatMock->end_of_month = $request->end_of_month;
            $vatMock->sales_income = $request->sales_income;
            $vatMock->exempted_supplies = $request->exempted_supplies;
            $vatMock->total_subject_to_vat = $request->total_subject_to_vat;
            $vatMock->vat_charged_by_you = $request->vat_charged_by_you;
            $vatMock->add_adjustments = $request->add_adjustments;
            $vatMock->total_output_vat = $request->total_output_vat;
            $vatMock->vat_on_domestic_supplies = $request->vat_on_domestics;
            $vatMock->add_adjustments_2 = $request->add_adjustment_two;
            $vatMock->vat_on_import = $request->vat_on_import;
            $vatMock->vat_payable_by_you = $request->total_vat_payable_by_you;
            $vatMock->not_vatable_supplies_vat = $request->not_vatable_supplies_vat;
            $vatMock->vat_taken_at_source = $request->vat_taken_at_source;
            $vatMock->total_input_vat = $request->total_input_vat;
            $vatMock->amount_refundable = $request->amount_refundable;
            $vatMock->save();
            $success = true;

            $query = view('CorpTax.MonthlyVatReturn', compact('success'));
            return $this->is_corptax_user_set($query);

        } else {
            return Redirect::intended('login');
        }

    }
    
    public function getMovementInVatPayable()
    {
        if (Auth::check()) {
            $query = view('CorpTax.MovementInVatPayable');
            return $this->is_corptax_user_set($query);
        } else {
            return Redirect::intended('login');
        }

    }
    public function postMovementInVatPayable(Request $request)
    {
        if (Auth::check()) {
            $taxMivp = new TaxMivp();
            $taxMivp->balance = $request->balance;
            $taxMivp->vat_output = $request->vat_output;
            $taxMivp->vat_input = $request->vat_input;
            $taxMivp->vat_lessPayment = $request->less_payment;
            $taxMivp->closing_balance = $request->closing_balance;
            $taxMivp->save();
            $success = true;
            $query = view('CorpTax.MovementInVatPayable', compact('success'));
            return $this->is_corptax_user_set($query);
        } else {
            return Redirect::intended('login');
        }
        
    }
    
    public function getLogTransaction()
    {
        if (Auth::check()) {
            $query = view('CorpTax.LogTransaction');
            return $this->is_corptax_user_set($query);
        }
        else
        {

            return Redirect::intended('login');

        }
    }
    
    public function postSalesLogTransaction(Request $request)
    {
        if (Auth::check()) {
        if(empty($request->gross_amount)) {
            $request->gross_amount = null;
        }
        
        if(empty($request->net_amount)) {
            $request->net_amount = null;
        }
        
        if(empty($request->vat_amount)) {
            $request->vat_amount = null;
        }
    
            $salesMock = new SalesMock();
            $salesMock->company_id = 3; //session value
            $salesMock->name_of_product = $request->name_of_product;
            $salesMock->price = $request->price;
            $salesMock->vatable = $request->vatable;
            $salesMock->gross_amount = $request->gross_amount;
            $salesMock->net_amount = $request->net_amount;
            $salesMock->vat_amount = $request->vat_amount;
            $salesMock->date = str_replace("/", "-", $request->date);
            $salesMock->save();
            $success = true;
            $query = view('CorpTax.LogTransaction', compact('success'));
            return $this->is_corptax_user_set($query);
        }else{
            return Redirect::intended('login');
        }
    }
    
    public function postPurchaseLogTransaction(Request $request)
    {
        if (Auth::check()) {
        if(empty($request->gross_amount)) {
            $request->gross_amount = null;
        }
        
        if(empty($request->net_amount)) {
            $request->net_amount = null;
        }
        
        if(empty($request->vat_amount)) {
            $request->vat_amount = null;
        }
        
        $purchaseMock = new PurchaseMock();
        $purchaseMock->company_id = 3; //session value
        $purchaseMock->name_of_product = $request->name_of_product;
        $purchaseMock->price = $request->price;
        $purchaseMock->vatable = $request->vatable;
        $purchaseMock->gross_amount = $request->gross_amount;
        $purchaseMock->net_amount = $request->net_amount;
        $purchaseMock->vat_amount = $request->vat_amount;
        $purchaseMock->date = str_replace("/", "-", $request->date);
        $purchaseMock->save();
        $success = true;
        $query = view('CorpTax.LogTransaction', compact('success'));
            return $this->is_corptax_user_set($query);
        } else {
            return Redirect::intended('login');
        }
        
    }
    
    /**
     * Get the sum of all vat amount in the tax_sales table
     */
    public function postSalesTotalVatOutput(Request $request)
    {
        //$salesTotal = DB::select(DB::raw("SELECT SUM(vat_amount) AS vat_sum FROM `tax_sales` WHERE date BETWEEN '".$request->start_date."'  AND '".$request->end_date."'"));
        $salesTotal = DB::select(
            DB::raw("SELECT SUM(vat_amount) AS vat_sum FROM `tax_sales` WHERE date BETWEEN :start_date  AND :end_date"), array(
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
            )
        );
        //$purchaseTotal = DB::select(DB::raw("SELECT SUM(vat_amount) as vat_sum FROM `tax_purchase` WHERE date BETWEEN '".$request->start_date."'  AND '".$request->end_date."'"));
        $purchaseTotal = DB::select(
            DB::raw("SELECT SUM(vat_amount) as vat_sum FROM `tax_purchase` WHERE date BETWEEN :start_date AND :end_date"), array(
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
            )
        );
        return json_encode(array($salesTotal,$purchaseTotal));
    }
    
    /**
     * Get the sum of all vat amount in the tax_purchase table
     */
    public function postPurchaseTotalVatOutput(Request $request)
    {
        //$details = DB::select(DB::raw("SELECT SUM(vat_amount) as sum FROM `tax_purchase` WHERE date BETWEEN '".$request->start_date."'  AND '".$request->end_date."'"));
        $details = DB::select(
            DB::raw("SELECT SUM(vat_amount) as sum FROM `tax_purchase` WHERE date BETWEEN :start_date  AND :end_date"), array(
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
            )
        );
        return json_encode($details);
    }
    
    
    
}