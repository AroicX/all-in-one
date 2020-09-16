<?php

namespace App\Repository\CorpTax;

use Illuminate\Support\Facades\Auth;
use App\Models\CorpTax\WHTMock;
use App\Models\CorpTax\WHTMovementScheduleMock;
use App\Services\CorpTax\ExcelProcessor;
use Carbon\Carbon;
use App\Traits\CorpTax\DateFormatter;
use Mockery\CountValidator\Exception;

class WHTRegistry
{

    use DateFormatter;
    /**
     * @var WHTMock
     */
    private $WHTMock;
    /**
     * @var WHTMovementScheduleMock
     */
    private $scheduleMock;

    /**
     * WITRegistry constructor.
     *
     * @param    WHTMock                 $WHTMock
     * @param    WHTMovementScheduleMock $scheduleMock
     * @internal param ExcelProcessor $xlsProcessor
     */
    public function __construct(WHTMock $WHTMock,WHTMovementScheduleMock $scheduleMock)
    {
        $this->WHTMock = $WHTMock;
        $this->scheduleMock = $scheduleMock;
    }


    /**
     * @param $data
     * @param $type
     * @param $processor
     * @return static
     */
    public function saveTransaction($data, $type,$processor = null)
    {
        return $type === 'excel'
            ? $this->saveFromExcel($data, $processor)
            : $this->saveFromForm($data);
    }

    /**Return amount payable by period
     *
     * @param $startDate
     * @param $endDate
     */
    public function amountPayableBy($startDate,$endDate)
    {
        $fromDate = null;
        $toDate   = null;
        $company_id = Auth::user()->company_id;

        empty($startDate)
            ? :  $fromDate =  $this->formatDateForDB($startDate);

        empty($endDate)
            ? : $toDate    =  $this->formatDateForDB($endDate);

        return  $this->WHTMock->where('company_id', $company_id)
            ->whereBetween('transaction_period', [$fromDate,$toDate])
            ->sum('WHT_amount');
    }

    public function saveAccountMovement($data)
    {
         $company_id = Auth::user()->company_id;
        $accountMovement = [
            'payment_id'             => 0,
            'company_id'             => $company_id,
            'balance_bf'             => isset($data['balance_bf']) ?$data['balance_bf'] :'' ,
            'payable_for_period'     => isset($data['payable_for_period']) ? $data['payable_for_period'] :'',
            'start_date'             => $this->formatDateForDB($data['period_start']),
            'end_date'               => $this->formatDateForDB($data['period-end'])  ,
            'payment_for_period'     => $data['payment_for_period'],
            'closing_balance'        => $data['closing_balance'],
        ];

        return  $this->scheduleMock->create($accountMovement);
    }

    /**
 * Get account movement
     *
     * @return mixed
     */
    public function getAccountMovement()
    {
        return $this->scheduleMock->orderBy('id', 'desc')
            ->take(1)
            ->first();
    }
    /**
     * Filter transactions by period
     *
     * @param  $from
     * @param  $to
     * @param  $type
     * @return mixed
     */
    public function filterByPeriod($type,$from,$to)
    {
        $toDate      = null;
        $fromDate    = null;
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $today       = Carbon::now('Africa/Lagos');

          empty($from)
              ? :  $fromDate =  $this->formatDateForDB($from);

         empty($to)
             ? : $toDate    =  $this->formatDateForDB($to);

        switch(true)
        {
        case ($fromDate && $toDate):
            return   $this->WHTMock->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->where('company_type', $type)
                ->whereBetween('transaction_period', [$fromDate,$toDate])
                ->orderBy('created_at', 'desc')
                ->get();
            break;
        case ($fromDate && is_null($toDate)):
            return   $this->WHTMock->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->where('company_type', $type)
                ->whereBetween('transaction_period', [$fromDate,$today])
                ->orderBy('created_at', 'desc')
                ->get();
            break;
        case (is_null($fromDate) && is_null($toDate)) :
            return $this->allTransactions();
            break;
        case (is_null($fromDate) && $toDate):
            return $this->WHTMock->where('company_id', $company_id)
                ->where('user_id', $user_id)
                ->where('company_type', $type)
                ->where('transaction_period', '<=', $toDate)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    /**
     * Get all transactions
     *
     * @return mixed
     */
    public function allTransactions()
    {
         $company_id = Auth::user()->company_id;
         $user_id = Auth::user()->id;
        return $this->WHTMock->where('user_id', $user_id)
            ->where('company_id', $company_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function saveFromExcel($value,$xlsProcessor)
    {
                 $company_id = Auth::user()->company_id;
         $user_id = Auth::user()->id;

        $transaction = [
        'user_id'               =>  $user_id,
        'company_id'            =>  $company_id,
        'vendor_name'         => isset($value[$xlsProcessor->vendorKey]) ? $value[$xlsProcessor->vendorKey] : '' ,
        'company_type'         => isset($value[$xlsProcessor->vendorTypeKey]) ? $value[$xlsProcessor->vendorTypeKey] : '' ,
        'vendor_address'        => isset($value[$xlsProcessor->addressKey]) ? $value[$xlsProcessor->addressKey] : '' ,
        'vendor_TIN'            => isset($value[$xlsProcessor->tinKey]) ? $value[$xlsProcessor->tinKey] : '' ,
        'nature_of_transaction' => isset($value[$xlsProcessor->transactionNatureKey]) ? $value[$xlsProcessor->transactionNatureKey] : '' ,
        'transaction_period'    => isset($value[$xlsProcessor->transactionDateKey]) ? date("Y-m-d h:s:i", strtotime($value[$xlsProcessor->transactionDateKey])) : '' ,
        'transaction_type'      => isset($value[$xlsProcessor->transactionTypeKey]) ? $value[$xlsProcessor->transactionTypeKey] : '' ,
        'invoice_amount'        => isset($value[$xlsProcessor->invoiceAmountKey]) ? $value[$xlsProcessor->invoiceAmountKey] : '' ,
        'WHT_rate'              => isset($value[$xlsProcessor->WHTRateKey]) ? $value[$xlsProcessor->WHTRateKey] : '' ,
        'WHT_amount'            => isset($value[$xlsProcessor->WHTAmountKey]) ? $value[$xlsProcessor->WHTAmountKey] : '' ,
            ];

                $this->WHTMock->create($transaction);


        return  response()->json('true');
    }

    /**
     * Save Transaction from form
     * 
     * @param  $data
     * @return static
     */

    public function saveFromForm($data)
    {
                         $company_id = Auth::user()->company_id;
         $user_id = Auth::user()->id;
        $transaction = [
            'user_id'               =>  $user_id,
            'company_id'            =>  $company_id,
            'company_type'          => $data['company_type'],
            'vendor_name'           => $data['vendor_name'],
            'vendor_address'        => $data['vendor_address'],
            'vendor_TIN'            => $data['vendor_TIN'],
            'nature_of_transaction' => $data['nature_of_activity'],
            'transaction_period'    => $this->formatDateForDB($data['transaction_period']),
            'transaction_type'      => $data['transaction_type'],
            'invoice_amount'        => $data['invoice_amount'],
            'WHT_rate'              => $data['WHT_rate'] ,
            'WHT_amount'            => $data['amount_of_WHT'] ,
        ];

        return $this->WHTMock->create($transaction);
    }

    /**
     * Search transactions
     *
     * @param $keyword
     */
    public function search($keyword)
    {
        $company_id = Auth::user()->company_id;
        return  $this->WHTMock->where('company_id', $company_id)
            ->where(
                function ($query) use ($keyword) {
                    $query->orWhere('vendor_name', 'LIKE', "%$keyword%");
                    $query->orWhere('vendor_address', 'LIKE', "%$keyword%");
                    $query->orWhere('vendor_TIN', 'LIKE', "%$keyword%");
                    $query->orWhere('WHT_rate', 'LIKE', "%$keyword%");
                    $query->orWhere('WHT_amount', 'LIKE', "%$keyword%");
                    $query->orWhere('transaction_type', 'LIKE', "%$keyword%");
                    $query->orWhere('nature_of_transaction', 'LIKE', "%$keyword%");
                }
            )
            ->orderBy('created_at', 'desc')
            ->get();
    }

}