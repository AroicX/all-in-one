<?php

namespace App\Traits\Flutterwave;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CorpHRM;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Validator;
use Illuminate\Support\Facades\Input;

trait AccessAccountTrait
{

    /**
   * urls to endpoints on staging and production server
     *
   * @var [type]
   */
    private static $accountResources = [
    "staging" => [
      "initiate" => "http://staging1flutterwave.co:8080/pwc/rest/recurrent/account/",
      "validate" => "http://staging1flutterwave.co:8080/pwc/rest/recurrent/account/validate/",
      "charge" => "http://staging1flutterwave.co:8080/pwc/rest/recurrent/account/charge/"
    ],
    "production" => [
      "initiate" => "https://prod1flutterwave.co:8181/pwc/rest/recurrent/account/",
      "validate" => "https://prod1flutterwave.co:8181/pwc/rest/recurrent/account/validate/",
      "charge" => "https://prod1flutterwave.co:8181/pwc/rest/recurrent/account/charge/"
    ]
    ];

    /**
   * setup a bank account for recurrent payment
     *
   * @param  string $accountNumber account number
   * @return ApiResponse
   */
    public static function initiate($accountNumber) 
    {
        self::validateClientCredentialsSet();

        $key = self::getApiKey();
        $accountNumber = self::encrypt3Des($accountNumber, $key);

        $resource = self::$accountResources[self::getEnv()]["initiate"];
        $resp = (new ApiRequest($resource))
              ->addBody("accountNumber", $accountNumber)
              ->addBody("merchantid", self::getMerchantKey())
              ->makePostRequest();
        return $resp;
    }

    /**
   * validate an initiated recurrent account payment
     *
   * @param  string           $ref           transactionReference from initiate method call
   * @param  string           $accountNum    account number
   * @param  string           $otp           otp sent to account owner
   * @param  int|double|float $billingAmount
   * @param  string           $narration     narration
   * @return ApiResponse
   */
    public static function val($ref, $accountNum, $otp, $billingAmount, $narration) 
    {
        $this->validateClientCredentialsSet();

        $key = $this->getApiKey();
        $ref = $this->encrypt3Des($ref, $key);
        $accountNum = $this->encrypt3Des($accountNum, $key);
        $otp = $this->encrypt3Des($otp, $key);
        $billingAmount = $this->encrypt3Des($billingAmount, $key);
        $narration = $this->encrypt3Des($narration, $key);

        $resource = self::$accountResources[$this->getEnv()]['validate'];
        $resp = (new ApiRequest($resource))
              ->addBody("merchantid", $this->getMerchantKey())
              ->addBody("otp", $otp)
              ->addBody("accountNumber", $accountNum)
              ->addBody("reference", $ref)
              ->addBody("billingamount", $billingAmount)
              ->addBody("debitnarration", $narration)
              ->makePostRequest();
        return $resp;
    }

    /**
   * charge a validated card
     *
   * @param  string           $token     account token
   * @param  int|double|float $amount    amount to charge the account
   * @param  string           $narration narration for charge
   * @return ApiResponse
   */
    public static function charge($token, $amount, $narration) 
    {
        $this->validateClientCredentialsSet();

        $key = $this->getApiKey();
        $token = $this->encrypt3Des($token, $key);
        $amount = $this->encrypt3Des($amount, $key);
        $narration = $this->encrypt3Des($narration, $key);

        $resource = self::$accountResources[$this->getEnv()]["charge"];
        $resp = (new ApiRequest($resource))
              ->addBody("merchantid", $this->getMerchantKey())
              ->addBody("accountToken", $token)
              ->addBody("billingamount", $amount)
              ->addBody("debitnarration", $narration)
              ->makePostRequest();
        return $resp;
    }

    public static function encrypt3Des($data, $key)
    {
        //Generate a key from a hash
        $key = md5(utf8_encode($key), true);

        //Take first 8 bytes of $key and append them to the end of $key.
        $key .= substr($key, 0, 8);

        //Pad for PKCS7
        $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = $blockSize - ($len % $blockSize);
        $data = $data.str_repeat(chr($pad), $pad);

        //Encrypt data
        $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');

        //return $this->strToHex($encData);

        return base64_encode($encData);
    }

    public static function decrypt3Des($data, $secret)
    {
        //Generate a key from a hash
        $key = md5(utf8_encode($secret), true);

        //Take first 8 bytes of $key and append them to the end of $key.
        $key .= substr($key, 0, 8);

        $data = base64_decode($data);

        $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');

        $block = mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = ord($data[$len-1]);

        return substr($data, 0, strlen($data) - $pad);
    }
    public static function validateClientCredentialsSet() 
    {
        if (empty(self::getMerchantKey()) || empty(self::getApiKey())) {
            throw new \Exception("You need to set merchant credentials first. Do `$this->setMerchantCredentials(merchantKey, apiKey);`");
        }
    }

}
