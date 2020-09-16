<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Rave;
use App\Events\PaymentEventHandler;

trait RavePaymentTrait
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    public function InitializeRavePay()
    {
        //This initializes payment and redirects to the payment gateway
        //The initialize method takes the parameter of the redirect URL
        //Use the eventHandler method and pass a new instance of your class implementing RaveEventHandlerInterface in the parameter
        Rave::eventHandler(new PaymentEventHandler)->initialize(route('RavePaymentCallback'));

        /***
        *For more functionality you can use more methods like the one below
        *setKeys($publicKey, $secretKey) - This is used to set the puvlic and secret key incase you wat to use another one different from your .env
        *setEnvironment($env) - This is used to set to either staging or live incase you want to use something different from your .env
        *
        *setPrefix($prefix, $overrideRefWithPrefix=false) - 
        ***$prefix - To add prefix to your transaction reference eg. KC will lead to KC_hjdjghddhgd737
        ***$overrideRefWithPrefix - either true/false. True will override the autogenerate reference with $prefix/request()->ref while false will use the $prefix as your prefix
        **/

        //Rave::eventHandler(new PaymentEventHandler)->setKeys($publicKey, $secretKey)->setEnvironment($env)->setPrefix($prefix, $overrideRefWithPrefix=false)->initialize(route('callback'));

        //eg: Rave::eventHandler(new PaymentEventHandler)->setEnvironment('live')->setPrefix("flamez")->initialize(route('callback'));
        //eg: Rave::eventHandler(new PaymentEventHandler)->setKeys("PWHNNJ992838uhzjhjshud", "PWHNNJ992838uhzjhjshud")->setPrefix(request()->ref, true)->initialize(route('callback'));
        //eg: Rave::eventHandler(new PaymentEventHandler)->setKeys("PWHNNJ992838uhzjhjshud, "PWHNNJ992838uhzjhjshud")->setEnvironment('staging')->setPrefix("rave", false)->initialize(route('callback'));
    }
}
