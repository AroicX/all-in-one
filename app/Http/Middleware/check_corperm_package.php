<?php

namespace App\Http\Middleware;

use Closure;
use App\corperm_packages;
use App\Subscription;
use App\Company;
use Auth;
use Illuminate\Support\Facades\Redirect;

class check_corperm_package
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $company_id, $module)
    {
        $check = $this->check_module($company_id, $module);
        if($check['status'] == "true"){
            return $next($request);
        }else{
            return redirect('/dashboard')->with(["error" => 'No access right!']);
        }
        
    }

    protected function corpfin_packages($plan_id){

        $row = corperm_packages::where(['id' => $plan_id, 'parent' => "CorpFIN"])->first();
            $package = json_encode($row['package']);
            $result = [
                'no_users' => $package['Maximum Users'],
                'maximum_departments' => $package['Maximum Branches/Departments'],
                'maximum_branches' => $package['Maximum Branches/Departments'],
                'MANRETAIL' => $package['Inventory Module (MANRETAIL)'],
                'process_costing' => $package['Process Costing'],
                'invoicing' => $package['Invoicing'],
                'basic_accounting_entries' => $package['Basic Accounting Entries'],
                'traditional_accounting_entries' => $package['Traditional Accounting Entries'],
                'custom_reports' => $package['Custom Reports'],
                'data_retention' => $package['Document & Data Retention']
            ];
        return $result;
    }

    protected function corphrm_packages($plan_id){

        $row = corperm_packages::where(['id' => $plan_id, 'parent' => "CorpHRM"])->first();
        $package = json_encode($row['package']);
        $result = [
            'company_profile_summary' => $package['Company Profile Summary'],
            'employee_records' => $package['Employee Records'],
            'recruitment_workflow' => $package['Recruitment workflow'],
            'performance_management' => $package['Performance Management'],
            'learning_tracker' => $package['Learning & Development Tracker'],
            'loans' => $package['Loans & Advances'],
            'advances' => $package['Loans & Advances'],
            'expense_reporting' => $package['Expense Reporting'],
            'payroll_processing' => $package['Payroll Processing'],
            'payroll_payments' => $package['Payroll Payments'],
            'employee_self_service' => $package['Employee Self Service'],
            'tax_return_forms' => $package['Tax Returns Forms'],
            'no_users' => $package['Maximum Users'],
            'data_retention' => $package['Document & Data Retention']
        ];
        return $result;
    }

    protected function corptax_packages($plan_id){

        $row = corperm_packages::where(['id' => $plan_id, 'parent' => "CorpTAX"])->first();
        $package = json_encode($row['package']);
        $result = [
            'data_upload_sync' => $package['Data Upload & Sync'],
            'data_retention' => $package['Document & Data Retention'],
            'vat_review' => $package['VAT Review'],
            'wht_review' => $package['WHT Review'],
            'cit_computation' => $package['CIT Computation'],
            'dit_computation' => $package['DIT Computation'],
            'pay_taxes' => $package['Pay Taxes'],
            'tax_reconciliation' => $package['Effective Tax Reconciliation'],
            'tax_account_movement' => $package['Tax Account Movements'],
            'payment_reports' => $package['Payment Reports'],
            'tax_analysis_report' => $package['Detailed Tax Analysis Report'],
            'custom_reports' => $package['Other Custom Reports'],
            'company_profile_summary' => $package['Company Profile Summary'],
            'tax_return_forms' => $package['Tax Returns Forms'],
            'no_users' => $package['Maximum Users']
        ];
        return $result;
    }

    protected function corpemt_packages($plan_id){

        $row = corperm_packages::where(['id' => $plan_id, 'parent' => "CorpTAX"])->first();
        $package = json_encode($row['package']);
        $result = [
            'data_upload_sync' => $package['Data Upload & Sync'],
            'data_retention' => $package['Document & Data Retention'],
            'number_engagements' => $package['Number of Engagements or Projects'],
            'number_contacts' => $package['Number of Contacts'],
            'engagement_management' => $package['Engagement Management'],
            'timesheets' => $package['Timesheets'],
            'job_scheduling' => $package['Job Scheduling and Tasks assignment'],
            'engagement_team_structure' => $package['Engagement Team Structure'],
            'rm_eap' => $package['Risk Management - Engagement Acceptance Process'],
            'rm_co' => $package['Risk Management - Client Overview'],
            'sec' => $package['Standard Engagement Contracts'],
            'crm' => $package['Customer Relationship Management (CRM)'],
            'eur' => $package['Employee Utilisation Reports'],
            'err' => $package['Engagement Realisation Reports'],
            'custom_reports' => $package['Other Custom Reports'],
            'company_profile_summary' => $package['Company Profile Summary'],
            'no_users' => $package['Maximum Users']
        ];
        return $result;
    }

    protected function corppay_packages($plan_id){

    }

    public function check_module($company_id, $module){
        $subscription = Subscription::where(['company_id' => $company_id,'product' => $module])->first();
        if($subscription){
            if($this->expiry_checker($subscription['id'])){
                // $module = "" ; //convert all to small letters
                $moduleName = strtolower($module);
               $package = $moduleName.'_packages'.($subscription['product_id']);
                return ['status' => 'true', 'package' => $package];
            }
            return ['status' => 'false'];
        }else{
            return ['status' => 'false'];
        }
    }

    protected function expiry_checker($id){
        return true;
    }
}
