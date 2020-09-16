<?php

namespace App\Http\Middleware;

use App\Models\CorpHRM\Qualification;
use App\Models\CorpHRM\Health;
use App\Models\CorpHRM\Pension;
use App\Models\CorpHRM\InternalRevenue;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Currency;
use App\Models\CorpHRM\Document;
use App\Models\CorpHRM\Weekoff;
use App\Models\CorpHRM\EmployeeCategory;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\Bank;
use App\Models\CorpHRM\Access_roles;
use App\Models\CorpHRM\Holiday;
use App\Models\CorpHRM\payroll\payroll;
use App\Models\CorpHRM\payroll\payroll_basic_settings;
use App\Models\CorpHRM\payroll\payroll_custom_settings;
use App\Models\CorpHRM\payroll\payroll_payee_settings;
use App\Models\CorpHRM\corphrm_email_templates;
use Auth;
use Closure;

class CorpHRMSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {  
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;

        $payroll_basic = count(payroll_basic_settings::where('company_id', $company_id)->get());
        $holiday = 1;
        //count(Holiday::where('company_id', $company_id)->get());
        $access_role = count(Access_roles::where('company_id', $company_id)->get());
        $bank = 1;
        //count(Bank::where('company_id', $company_id)->get());
        $designation = count(Designation::where('company_id', $company_id)->get());
        $grade = count(Grade::where('company_id', $company_id)->get());
        $category = 1;
        //count(EmployeeCategory::where('company_id', $company_id)->get());
        $weekend = count(Weekoff::where('company_id', $company_id)->get());
        $document = 1;
        //count(Document::where('company_id', $company_id)->get());
        $currency = 1;
        //count(Currency::where('company_id', $company_id)->get());
        $department = count(Department::where('company_id', $company_id)->get());
        $branch = count(Branch::where('company_id', $company_id)->get());
        $ir = 1;
        //count(InternalRevenue::where('company_id', $company_id)->get());
        $pension = 1;
        //count(Pension::where('company_id', $company_id)->get());
        $health = 1;
        //count(Health::where('company_id', $company_id)->get());
        $qualification = 1;
        //count(Qualification::where('company_id', $company_id)->get());
        $email_templates = 11;
        count(corphrm_email_templates::where('company_id', $company_id)->get());
        //$payroll_basic = count(payroll_basic_settings::where('company_id', $company_id)->get());
        if($payroll_basic < 1 || $holiday < 1 || $access_role < 1 || $bank < 1 || $designation < 1 || $grade < 1 || $category < 1 || $weekend < 1 ||$document < 1 || $currency < 1 || $department < 1 || $branch < 1 || $ir < 1 || $pension < 1 || $health < 1 || $qualification < 1 || $payroll_basic < 1 || $email_templates < 11){
            return redirect('corphrm/settings')->with(["success" => 'Some settings are pending!']);
        }
        return $next($request);
      }

}