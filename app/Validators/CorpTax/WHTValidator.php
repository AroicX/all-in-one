<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/24/16
 * Time: 7:02 PM
 */

namespace App\Validators\CorpTax;


use Validator;

class WHTValidator extends Validator
{

    public function validateTransaction($request)
    {
        return \Validator::make(
            $request->all(),
            [
                'vendor_name'=>'required',
                'vendor_address' =>'required',
                'vendor_TIN'   => 'required',
                'nature_of_activity' => 'required',
                'transaction_type' => 'required',
                'transaction_period' => 'required',
                'invoice_amount' => 'required',
                


            ]
        );
    }

}