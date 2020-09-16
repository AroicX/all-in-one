<?php
/**
 * Created by PhpStorm.
 * User: proteux3
 * Date: 12/23/16
 * Time: 5:04 PM
 */

namespace App\Http\Controllers\CorpTax;


use App\Repository\CorpTax\WHTRegistry;
use App\Services\CorpTax\ExcelProcessor;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class WHTController extends CorpTaxController
{
    /**
     * @var WHTRegistry
     */
    private $WHTRegistry;
    /**
     * @var Request
     */
    private $request;

    protected $tinKey;
    /**
     * @var ExcelProcessor
     */
    private $xlsProcessor;


    /**
     * WHTController constructor.
     * @param WHTRegistry $WHTRegistry
     * @param Request $request
     * @param ExcelProcessor $xlsProcessor
     */
    public function __construct(WHTRegistry $WHTRegistry,
                                Request $request,
                                ExcelProcessor $xlsProcessor)
    {
        $this->WHTRegistry = $WHTRegistry;
        $this->request = $request;
        $this->xlsProcessor = $xlsProcessor;
    }
    

    /**
     * Return view for logTransactions
     * 
     * @return mixed
     */
   public function getLogTransactions()
   {
       return view('CorpTax.WIT.logTransactions');
   }

    /**
     * @return mixed
     */
    public function getAccountsMovement()
    {
        return view('CorpTax.WIT.accountsMovement');
    }
    
    public function viewTransactions()
    {
         $transactions = $this->WHTRegistry->allTransactions();
        
        return view('CorpTax.WIT.viewTransactions')
            ->with(['transactions'=> $transactions]);
    }

    
    public function getAmountPayableBy()
    {
        $startDate = $this->request->get('start');
        $endDate   = $this->request->get('end');
        
        return  response()->json($this->WHTRegistry->amountPayableBy($startDate,$endDate));
    }
    /**
     *Filter transactions by date 
     */
    public function filterTransactions()
    {
         $transactions = $this->WHTRegistry
             ->filterByPeriod($this->request->get('type'),
                 $this->request->get('from'),
                 $this->request->get('to'));

        return \Response::json($transactions);
    }

    /**
     * Search transactions
     * 
     * @return mixed
     */
    public function searchTransactions()
    {
        return response()->json(
            $this->WHTRegistry->search($this->request->get('data')));
    }

    /**
     * Save account movement
     * 
     * @return mixed
     */
    public function saveAccountMovement()
    {

        $response =  $this->WHTRegistry->saveAccountMovement($this->request->all());
        return $response
            ? response()->json(['status'=>'success'])
            :   response()->json(['status'=>'error']);
    }
    /**
     * Download Remittance Schedule template
     */
    public function downloadRemittanceScheduleTemplate()
    {
        $pathToFile = base_path('storage/app/clearance letter.docx');
        $name       = 'WHT Transaction Template.docx';
        $headers    = [ 'Content-Type'=> 'application/msword',];

        return response()->download($pathToFile, $name,$headers);
    }

    /**
     * read transactions from excel
     * @param Request $request
     * @param $filesystem
     * @return string
     */
    public function uploadTransactions(Request $request, Filesystem $filesystem)
    {
//        $this->validate($request->get('excel_transaction'),
//            [
//                'excel_transaction' => 'mimes:xlsx,xls'
//            ]);

        $filePath =   $this->saveTransactionExcelFileTemporarily(
            $request->file('excel_transaction'),$filesystem);

         return $this->processExcel($filePath,$this->request->except('excel_transaction'));

    }


    /**
     * @param $file
     * @param $filesystem
     * @return string
     */
    public function saveTransactionExcelFileTemporarily($file, $filesystem)
    {
        $tempDir      = base_path('storage/app/temp');
        $originalName = $file->getClientOriginalName();

        $filesystem->exists($tempDir) ? : $filesystem->makeDirectory($tempDir);
        $file->move($tempDir,$originalName);

        return  $tempDir.'/'.$originalName;

    }

    /**
     * Process the excelFile Containing the transactions
     *
     * @param $filePath
     * @param $data
     * @return
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     */
    public function processExcel($filePath,$data)
    {
        return $this->xlsProcessor->processExcel($filePath,$data)
            ? $this->saveData($filePath)
            :  response()->json(
                [
                    'status'=>'error',
                    'statusText'=>'incorrect header name in excel'
                ]);
    }

    /**
     * print accoount  movement
     */
    public function printAccountMovement()
    {
        $movement = $this->WHTRegistry->getAccountMovement();

//        echo $movement;

        return view('CorpTax.WIT.printAccountMovement')->with('movement',$movement);
    }
    
    

    /**
     * Save the date from excel to DB
     *
     * @param $filePath
     * @return mixed
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     */
    public function saveData($filePath)
    {
        $reader    = ReaderFactory::create(Type::XLSX);
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $value) {
                if($key !== 1)
                $this-> WHTRegistry
                    ->saveTransaction($value,$type='excel',$this->xlsProcessor);
            }
        }

        $reader->close();
        !file_exists($filePath) ? : @unlink($filePath);
        
        return response()->json(
            [
                'status'=>'success',
                'statusText'=>'transaction upload was successful'
            ]);
    }

    /**
     * @param Request $request
     * @return static
     */
    public function saveTransaction(Request $request)
    {
        return  $this->WHTRegistry->saveTransaction($request->all(),$type = null)
            ?  response()->json(['status'=>'success'])
            :  response()->json(['status'=>'error']);
    }


    public function printRemittanceSchedule( $type,$fromDate = null,$toDate = null)
    {
        // set the timestamp to West Africa time
        date_default_timezone_set('Africa/lagos');

            $fromDate !== 'null' ? $from = date('m/d/Y',$fromDate) : $from = '';
            $toDate !== 'null' ? $to = date('m/d/Y',$toDate) : $to = '';

        $transactions = $this->WHTRegistry
            ->filterByPeriod($type,$from,$to);


        return view('CorpTax.WIT.printRemittanceSchedule',compact('transactions'));

    }

    /**
     * Print Remittance schedule
     */
    public function preparePrintView()
    {

    }
}