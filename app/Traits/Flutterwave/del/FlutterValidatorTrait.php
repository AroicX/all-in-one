<?php
namespace  App\Traits\Flutterwave;

use App\Traits\Flutterwave\FlutterwaveTrait;

trait FlutterValidatorTrait
{
    use FlutterwaveTrait;
    public function validateClientCredentialsSet() 
    {
        if (empty($this->getMerchantKey()) || empty($this->getApiKey())) {
            throw new \Exception("You need to set merchant credentials first. Do `$this->setMerchantCredentials(merchantKey, apiKey);`");
        }
    }
}
