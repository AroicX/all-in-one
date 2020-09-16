<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Get states
Route::get('getstates/{country_id}', array('uses' => 'SubscriptionController@Get_states'));

/* Online Payments Route
*/
// Rave Pay
Route::post('/payment/rave/pay', 'RavePaymentController@initialize')->name('RavePay');
Route::post('/payment/rave/callback', 'RavePaymentController@callback')->name('RavePaymentCallback');
Route::post('/postSubscription', array('uses' => 'SubscriptionController@post_subscription'))->name('PostSubscription');
Route::post('/rave/webhook/afterpayment', array('uses' => 'SubscriptionController@ravepay_after_transaction_webhook'))->name('RaveWebhookAfterPayment');
Route::post('/rave/webhook/beforepayment', array('uses' => 'SubscriptionController@ravepay_before_transaction_webhook'))->name('RaveWebhookBeforePayment');

/*Route::group(['prefix' => 'corpfin', 'middleware' => []], function () {
    Route::get('transaction/{id}', 'CorpFinTransTypeCtrl@getTransactionType')->name("corpfin.api.transaction.type");
    //product

});
*/
