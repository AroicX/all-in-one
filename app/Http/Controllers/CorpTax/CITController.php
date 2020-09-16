<?php

namespace App\Http\Controllers\CorpTax;

use Illuminate\Http\Request;
use App\Model\CorpTax\CIT\Rates;
use App\Model\CorpTax\CIT\Assets;
use App\Repository\CorpTax\CITRegistry;
use App\Services\CorpTax\ExcelProcessor;
use App\Services\CorpTax\TrialBalanceManager;
use Illuminate\Support\Facades\Auth;
use App\Traits\SubscriptionTrait;
use App\Http\Controllers\CorpFIN\CorpFinCITController;
use Redirect;
class CITController extends CorpTaxController
{
    use SubscriptionTrait;
    /**
     * @var ExcelProcessor
     */
    private $xlsProcessor;
    /**
     * @var CITRegistry
     */
    private $CITRegistry;
    /**
     * @var Request
     */
    private $request;

    /**
     * CITController constructor.
     * @param ExcelProcessor $xlsProcessor
     * @param CITRegistry $CITRegistry
     * @param Request $request
     */
    public function __construct(ExcelProcessor $xlsProcessor,
                                CITRegistry $CITRegistry,Request $request)
    {
        $this->xlsProcessor = $xlsProcessor;
        $this->CITRegistry = $CITRegistry;
        $this->request = $request;
    }

    /**
     * Return the CIT Computation page
     */
    public function getCITComputation()
    {
        if (Auth::check()) {
            $exclude_array = ['5000020088','5000020089', '5000020090', '5000020091','5000020092', '5000020093', '5000020094', '5000020095', '5000020096', '5000020097', '5000020098'];
            $excluded_expenses = CorpFinCITController::get_accounts(array(31, 32), $exclude_array, null);
            $query =  view('CorpTax.CIT.cit_computation')->with(['excluded_expenses' => $excluded_expenses]);
            return $this->is_corptax_user_set($query);
        }
        else
        {
            return Redirect::intended('login');
        }
    }


    /**
     * Save Trial Balance to temp dir
     */
    public function saveTrialBalanceToTempDir(){

        $tempDir = base_path('storage/app/templates');
        $trialBalance = $this->request->file('trial_balance');
        $name =  $trialBalance->getClientOriginalName();

        file_exists($tempDir) ? : mkdir($tempDir);

        $trialBalance->move($tempDir,$name);

        return $tempDir.'/'.$name;

    }
    /**
     * Upload Trial Balance
     */
    public function uploadTrialBalance()
    {
        if (Auth::check()) {
        $excelData =  $this->xlsProcessor->processTrialBalance($this->saveTrialBalanceToTempDir());

        \Cache::add('excelData',$excelData,300);

        $debitTotal   =  $excelData[1][count($excelData[1]) -1];
        $creditTotal  =  $excelData[2][count($excelData[2]) -1];

        $error = 'There is an error in the trial balance. Check the DEBIT and CREDIT total and try again';

        $query = $debitTotal == $creditTotal
            ? view('CorpTax.CIT.trial-balance-mapping')->with('excelData',$excelData)
            : redirect('/dashboard/corp-tax/CIT/cit-computation')->with('error',$error);
            return $this->is_corptax_user_set($query);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    /**
     * @param TrialBalanceManager $trialBalanceManager
     */
    public function mapTrialBalance(TrialBalanceManager $trialBalanceManager){
        if (Auth::check()) {
        $mappings = $this->request->all();
        $excelData  = \Cache::get('excelData');

        $message = 'Trial Balance has been uploaded successfully';
        $error   =  'Trial Balance was not uploaded. Please try again';

        $query = $trialBalanceManager->mapTrialBalanceEntry($mappings,$excelData)
            ? redirect('/dashboard/corp-tax/CIT/cit-computation')->with('success',$message)
            : redirect('/dashboard/corp-tax/CIT/cit-computation')->with('error',$error);
        return $this->is_corptax_user_set($query);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    /**
     * Return the company profile update view
     *
     * @return mixed
     */
    public function getUpdateProfile()
    {
        if (Auth::check()) {
        $Profile = $this->CITRegistry->getCompanyProfile();

        $query = view('CorpTax.CIT.update-company-profile')->with('Profile',$Profile);
        return $this->is_corptax_user_set($query);
        }
        else
        {
            return Redirect::intended('login');
        }
    }

    /**
     * Download the trial balance template
     *
     * @return mixed
     */
    public function downloadTrialBalanceTemplate()
    {
        $pathToFile = base_path('storage/app/templates/trial-balance-sample.xlsx');
        $name       = 'TrialBalanceTemplate.xlsx';
        $headers    = [ 'Content-Type'=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',];

        return response()->download($pathToFile, $name,$headers);
    }

   // protected $request;
   // function __construct(Request $request)
   // {
   //     $this->request = $request;
  //  }
    //Kunle's work starts here

    public function getIndex()
    {
        return view('CorpTax.CIT.index');
    }

    public function uploadFile(Request $request)
    {
        $request->file('doc')->move(public_path('docs'), $request->file('doc')->getClientOriginalName());
        return $request->file('doc')->getClientOriginalName();
    }

    public function viewFile()
    {
        $path = public_path('docs');
        $file_path = $path.'capital_allowance.xls';
        $excel = \Excel::load(
            $path.'\capital_allowance.xls', function ($reader) {
            }
        )->get();
        return $excel;
    }

    public function getIncomeEduTax()
    {
        return view('CorpTax.CIT.income_edu_tax');
    }

    public function getAddAsset()
    {
        $rates = Rates::get();
        return view('CorpTax.CIT.add_asset', compact('rates'));
    }

    public function postAddAsset(Request $request)
    {
        $asset = new Asset();
        $asset->asset = $request->formData[0];
        $asset->cost = $request->formData[1];
        $asset->initial_allowance_rate = $request->formData[2];
        $asset->annual_allowance_rate = $request->formData[3];
        $asset->investment_allowance_rate = $request->formData[4];
        $asset->initial_allowance = $request->formData[5];
        $asset->annual_allowance = $request->formData[6];
        $asset->investment_allowance = $request->formData[7];
        $asset->total = $request->formData[8];
        $asset->save();

        $success = "success";
        return $success;
    }

    public function getRate(Request $request)
    {
        $id = $request->id;
        $rate = Rates::find($id);

        $result = json_encode($rate);
        return $result;
    }

    public function getCapitalAllowance()
    {
        $assets = Assets::get();
        return view('CorpTax.CIT.capital_allowance', compact('assets'));
    }

    public function getCompanyIncomeTax()
    {
        return view('CorpTax.CIT.company_income_tax');
    }

    public function getDeferTaxComputation()
    {
        return view('CorpTax.CIT.defer_tax_computation');
    }

    public function getEffectiveTaxRate()
    {
        return view('CorpTax.CIT.effective_tax_rate');
    }

}