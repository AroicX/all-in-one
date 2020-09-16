<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/25/16
 * Time: 6:48 PM
 */

namespace App\Services\CorpTax;


use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;

class ExcelProcessor
{

    public $vendorKey;

    public $vendorTypeKey;

    public $addressKey;

    public $tinKey;

    public $transactionNatureKey;

    public $transactionDateKey;

    public $transactionTypeKey;

    public $invoiceAmountKey;

    public $WHTRateKey;

    public $WHTAmountKey;

    /**
     * Process Excel sheet
     *
     * @param  $filePath
     * @param  $data
     * @return mixed
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     */
    public function processExcel($filePath,$data)
    {
        $reader    = ReaderFactory::create(Type::XLSX);

        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $value) {

                return  $this->mapColumnHeaders($data, $value);
            }
        }

        $reader->close();

        return true;
    }

    /**
     * Map column headers to the database column names
     *
     * @param  $data
     * @param  $columnHeader
     * @param  $filePath
     * @return
     */
    public function mapColumnHeaders($data,$columnHeader)
    {
        $count               = 0;

        $vendor              = $data['vendor_name'];
        $vendorType          = $data['company_type'];
        $address             = $data['vendor_address'];
        $TIN                 = $data['vendor_TIN'];
        $transactionNature   = $data['nature_of_transaction'];
        $transactionDate     = $data['transaction_date'];
        $transactionType     = $data['transaction_type'];
        $invoiceAmount       = $data['invoice_amount'];
        $WHTRate             = $data['WHT_rate'];
        $WHTAmount           = $data['WHT_amount'];

        foreach($columnHeader as $key => $value)
        {

            switch(true)
            {
            case($value == $vendor):
                $this->vendorKey = $key;
                $count++;
                break;
            case($value == $vendorType):
                $this->vendorTypeKey = $key;
                $count++;
                break;
            case($value === $address):
                $this->addressKey = $key;
                $count++;
                break;
            case($value === $TIN):
                $this->tinKey = $key;
                $count++;
                break;
            case($value === $transactionNature):
                $this->transactionNatureKey = $key;
                $count++;
                break;
            case($value === $transactionDate):
                $this->transactionDateKey = $key;
                $count++;
                break;
            case($value === $transactionType):
                $this->transactionTypeKey = $key;
                $count++;
                break;
            case($value === $invoiceAmount):
                $this->invoiceAmountKey = $key;
                $count++;
                break;
            case($value === $WHTRate):
                $this->WHTRateKey = $key;
                $count++;
                break;
            case($value === $WHTAmount):
                $this->WHTAmountKey = $key;
                $count++;
                break;
            }
        }

        return  $count == 10 ?  true :  false;

    }

    public function processTrialBalance($filePath)
    {
        $reader    = ReaderFactory::create(Type::XLSX);

        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $value) {
                if($key !== 1)
                    $this->prepareExcelForMapping($value);
            }
        }

        $reader->close();

        return [$this->item,$this->debit,$this->credit];
    }


    /**
     * @param $value
     * @return bool
     */
    public function prepareExcelForMapping($value){
        if(empty($value[0])){
            return;
        }else{
            $this->item[] = $value[0];
            $this->debit[] = $value[1];
            $this->credit[] = $value[2];
        }


    }
}