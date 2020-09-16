<?php

namespace App\Events;

use Redirect;
//use the Rave Event Handler Interface
use KingFlamez\Rave\RaveEventHandlerInterface;
use App\Subscription;
use App\Trial;
use App\RavePayment as RavePaymentModel;

// This is where you set how you want to handle the transaction at different stages
// You can have multiple Event Handler for different purposes of payments

//This class should implement  the RaveEventHandlerInterface and take all the methods
class PaymentEventHandler implements RaveEventHandlerInterface{
    /**
     * This is called when the Rave class is initialized
     * */
    function onInit($initializationData){
        // Save the transaction to your DB.
        // echo 'Payment started......'.json_encode($initializationData).'<br />'; //Remember to delete this line
    }
    
    /**
     * This is called only when a transaction is successful
     * */
    function onSuccessful($transactionData){
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Comfirm that the transaction is successful
        // Confirm that the chargecode is 00 or 0
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here
        echo 'Payment Successful!'.json_encode($transactionData).'<br />'; //Remember to delete this line
        return Redirect::back()->with('success', 'Subscription successful!');
    }
    
    /**
     * This is called only when a transaction failed
     * */
    function onFailure($transactionData){
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here
        echo 'Payment Failed!'.json_encode($transactionData).'<br />'; //Remember to delete this line
    }
    
    /**
     * This is called when a transaction is requeryed from the payment gateway
     * */
    function onRequery($transactionReference){
        // Do something, anything!
        echo 'Payment requeried......'.$transactionReference.'<br />'; //Remember to delete this line
    }
    
    /**
     * This is called a transaction requery returns with an error
     * */
    function onRequeryError($requeryResponse){
        // Do something, anything!
        echo 'An error occured while requeying the transaction...'.json_encode($requeryResponse).'<br />'; //Remember to delete this line
    }
    
    /**
     * This is called when a transaction is canceled by the user
     * */
    function onCancel($transactionReference){
        // Do something, anything!
        // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution
        echo 'Payment canceled by user......'.$transactionReference.'<br />'; //Remember to delete this line
    }
    
    /**
     * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
     * */
    function onTimeout($transactionReference, $data){
        // Get the transaction from your DB using the transaction reference (txref)
        // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
        // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects
        echo 'Payment timeout......'.$transactionReference.' - '.json_encode($data).'<br />'; //Remember to delete this line
    }

    protected function ravepay_after_transaction(Request $request){
        $status = "2";  //transaction failed
        $refx_code = $this->input('txRef');
        $amount = $this->input('amount');
        $charged_amount = $this->input('charged_amount');
        if($this->input('status') == "successful")$status = "1"; //transaction successful
        Trial::updateOrCreate(['refx_code' => $refx_code], ['status' => $status, 'amount' => $amount]);
        $trial_data = Trial::where('refx_code', $refx_code)->first();
        $payment_data = [
            'user_id' => $trial_data['user_id'],
            'company_id' => $trial_data['company_id'],
            'refx_code' => $refx_code,
            'amount' => $amount,
            'charged_amount' => $charged_amount,
            'narration' => $trial_data['narration'],
            'status' => $status
        ];
        RavePaymentModel::create($payment_data);
        if($trial_data['narration'] == "Subscription"){
            $thic->subscribe_client($refx_code);
        }
        return json_encode(['status' => "successful"]);
    }

    protected function subscribe_client($refx_code){
        $trial_data = Trial::where('refx_code', $refx_code)->first();
        if($trial_data['narration'] == "Subscription"){
            $meta_data = json_decode($trial_data['meta']);
            foreach($meta_data as $subscription_detail){
                $subscription_data = [
                    'company_id' => $trial_data['company_id'],
                    'product_id' => $subscription_detail['package_id'],
                    'product' => $subscription_detail['parent'],
                    'date' => date('Y-m-d'),
                    'time' => date('h:i:s'),
                    'duration' => $subscription_detail['duration'],
                    'refx_code' => $refx_code,
                    'status' => "1"
                ];
                Subscription::create($subscription_data);
            }
        }
        return true;
    }
}