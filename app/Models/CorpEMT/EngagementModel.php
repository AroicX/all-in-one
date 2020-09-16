<?php 
namespace App\Models\CorpEMT;
use DB;
use Illuminate\Database\Eloquent\Model;

class EngagementModel extends Model
{
    protected     $management_table         = 'eng_management',
                $audit_committee_table     = 'eng_audit_committee',
                $basic_table             = 'eng_basic',
                $company_table             = 'eng_company',
                $financial_table         = 'eng_financial',
                $industry_table         = 'eng_industry',
                $economics_table         = 'eng_economics',
                $proposed_budget_table     = 'eng_budget';


    /*
    *this method gets all general information needed, by client id and company id
    */
    public function get_basic_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->basic_table)->select('billing_address', 'billing_attention', 'billing_city', 'billing_email', 'registered_country')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->first();
    }


    /*
    *this method decides whether to save the general information as new or update the existing information
    */
    public function save_basic_information($deal_id, $client_id, $billing_address, $billing_city, $registered_country, $billing_attention, $billing_email, $company_id)
    {
        $check = DB::table($this->basic_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        $count = $check->count();

        if ($count > 0) {
            return $this->update_basic_information($deal_id, $client_id, $billing_address, $billing_city, $registered_country, $billing_attention, $billing_email, $company_id);
        }
        else
        {
            return $this->new_basic_information($deal_id, $client_id, $billing_address, $billing_city, $registered_country, $billing_attention, $billing_email, $company_id);
        }
    }

    /*
    *this method saves general information as new
    */
    protected function new_basic_information($deal_id, $client_id, $billing_address, $billing_city, $registered_country, $billing_attention, $billing_email, $company_id)
    {
        $save = DB::table($this->basic_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'billing_address'=>ucfirst($billing_address), 'billing_city'=>ucfirst($billing_city), 'registered_country'=>ucfirst($registered_country), 'billing_attention'=>ucwords($billing_attention), 'billing_email'=>strtolower($billing_email), 'company_id'=>$company_id]);

        return $save;
    }


    /*
    *this method updates existing general information
    */
    protected function update_basic_information($deal_id, $client_id, $billing_address, $billing_city, $registered_country, $billing_attention, $billing_email, $company_id)
    {
        $update = DB::table($this->basic_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id])->update(['billing_address'=>ucfirst($billing_address), 'billing_city'=>ucfirst($billing_city), 'registered_country'=>ucfirst($registered_country), 'billing_attention'=>ucwords($billing_attention), 'billing_email'=>strtolower($billing_email)]);

        return $update;
    }



    public function get_industry_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->industry_table)->select('operation', 'product_and_services', 'regulatory_requirement')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->first();
    }



    public function save_industry_information($operation, $product_and_services, $requirement, $deal_id, $client_id, $company_id)
    {
        $check = DB::table($this->industry_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        $count = $check->count();

        if ($count > 0) {
            return $this->update_industry_information($operation, $product_and_services, $requirement, $deal_id, $client_id, $company_id);
        }    
        else
        {
            return $this->new_industry_information($operation, $product_and_services, $requirement, $deal_id, $client_id, $company_id);
        }
    }


    protected function new_industry_information($operation, $product_and_services, $requirement, $deal_id, $client_id, $company_id)
    {
        $save = DB::table($this->industry_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'operation'=>ucfirst($operation), 'product_and_services'=>ucfirst($product_and_services), 'regulatory_requirement'=>ucfirst($requirement)]);
        return $save;
    }


    protected function update_industry_information($operation, $product_and_services, $requirement, $deal_id, $client_id, $company_id)
    {
        $update = DB::table($this->industry_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id])->update(['operation'=>ucfirst($operation), 'product_and_services'=>ucfirst($product_and_services), 'regulatory_requirement'=>ucfirst($requirement)]);
        return $update;
    }




    public function get_financial_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->financial_table)->select('historical_info', 'assets', 'liabilities', 'revenue_and_market', 'liquidity')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->first();
    }



    public function save_financial_information($historical_info, $assets, $liabilities, $revenue_and_market, $liquidity, $deal_id, $client_id, $company_id)
    {
        $check = DB::table($this->financial_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        $count = $check->count();

        if ($count > 0) {
            return $this->update_financial_information($historical_info, $assets, $liabilities, $revenue_and_market, $liquidity, $deal_id, $client_id, $company_id);
        }
        else
        {
            return $this->new_financial_information($historical_info, $assets, $liabilities, $revenue_and_market, $liquidity, $deal_id, $client_id, $company_id);
        }
    }


    protected function new_financial_information($historical_info, $assets, $liabilities, $revenue_and_market, $liquidity, $deal_id, $client_id, $company_id)
    {
        $save = DB::table($this->financial_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'historical_info'=>$historical_info, 'assets'=>$assets, 'liabilities'=>$liabilities, 'revenue_and_market'=>ucfirst($revenue_and_market), 'liquidity'=>$liquidity]);

        return $save;
    }



    protected function update_financial_information($historical_info, $assets, $liabilities, $revenue_and_market, $liquidity, $deal_id, $client_id, $company_id)
    {
        $update = DB::table($this->financial_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id])->update(['historical_info'=>$historical_info, 'assets'=>$assets, 'liabilities'=>$liabilities, 'revenue_and_market'=>ucfirst($revenue_and_market), 'liquidity'=>$liquidity]);

        return $update;
    }


    public function get_company_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->company_table)->select('company', 'potential_client', 'cac', 'go_public', 'structure', 'share_capital')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->first();
    }


    public function save_company_information($company_type, $potential_client, $go_public, $structure, $share_capital, $cac, $deal_id, $client_id, $company_id)
    {
        $check = DB::table($this->company_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        $count = $check->count();

        if ($count > 0) {
            return $this->update_company_information($company_type, $potential_client, $go_public, $structure, $share_capital, $cac, $deal_id, $client_id, $company_id);
        }
        else
        {
            return $this->new_company_information($company_type, $potential_client, $go_public, $structure, $share_capital, $cac, $deal_id, $client_id, $company_id);
        }
    }


    public function new_company_information($company_type, $potential_client, $go_public, $structure, $share_capital, $cac, $deal_id, $client_id, $company_id)
    {
        $save = DB::table($this->company_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'company'=>$company_type, 'potential_client'=>$potential_client, 'cac'=>$cac, 'go_public'=>$go_public, 'structure'=>ucfirst($structure), 'share_capital'=>$share_capital]);

        return $save;
    }    


    public function update_company_information($company_type, $potential_client, $go_public, $structure, $share_capital, $cac, $deal_id, $client_id, $company_id)
    {
        $update = DB::table($this->company_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id])->update(['company'=>$company_type, 'potential_client'=>$potential_client, 'cac'=>$cac, 'go_public'=>$go_public, 'structure'=>ucfirst($structure), 'share_capital'=>$share_capital]);

        return $update;
    }



    public function get_management_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->management_table)->select('id', 'title', 'name', 'position', 'description', 'work_experience')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->get();
    }


    public function save_management_information($title, $name, $position, $description, $experience, $deal_id, $client_id, $company_id)
    {
        $save = $this->new_management_information($title, $name, $position, $description, $experience, $deal_id, $client_id, $company_id);
        return $save;
    }



    protected function new_management_information($title, $name, $position, $description, $experience, $deal_id, $client_id, $company_id)
    {
        $save = DB::table($this->management_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'title'=>$title, 'name'=>ucwords($name), 'position'=>ucfirst($position), 'description'=>ucfirst($description), 'work_experience'=>ucfirst($experience)]);

        return $save;
    }


    public function update_management_information($title, $name, $position, $description, $experience, $management_id)
    {
        $update = DB::table($this->management_table)->where('id', $management_id)->update(['title'=>$title, 'name'=>ucwords($name), 'position'=>ucfirst($position), 'description'=>ucfirst($description), 'work_experience'=>ucfirst($experience)]);

        return $update;
    }


    public function get_audit_committee_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->audit_committee_table)->select('id', 'name', 'position')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->get();
    }



    public function save_audit_committee_information($name, $position, $deal_id, $client_id, $company_id)
    {
        $save = $this->new_audit_committee_information($name, $position, $deal_id, $client_id, $company_id);
        return $save;
    }



    protected function new_audit_committee_information($name, $position, $deal_id, $client_id, $company_id)
    {
        $save = DB::table($this->audit_committee_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'name'=>ucwords($name), 'position'=>$position]);

        return $save;
    }


    public function update_audit_committee_information($name, $position, $committee_id)
    {
        $update = DB::table($this->audit_committee_table)->where('id', $committee_id)->update(['name'=>ucwords($name), 'position'=>$position]);

        return $update;
    }



    public function delete_audit_committee($id)
    {
        if (!empty($id)) {
            if (is_array($id)) {
                foreach ($id as $value) 
                {
                    $delete = DB::table($this->audit_committee_table)->where('id', $value)->delete();
                }
            }
            else
            {
                $delete = DB::table($this->audit_committee_table)->where('id', $value)->delete();
            }    

            return $delete;
        }
        
    }



    public function delete_management($id)
    {
        if (!empty($id)) {
            if (is_array($id)) {
                foreach ($id as $value) {
                    $delete = DB::table($this->management_table)->where('id', $value)->delete();
                }
            } elseif(is_numeric($id)) {
                $delete = DB::table($this->management_table)->where('id', $id)->delete();
            }else{
                return false;
            }

            return $delete;
        }

        return false;
    }


    public function delete_item($id){
        if (!empty($id)) {
            if (is_array($id)) {
                foreach ($id as $value){
                    $delete = DB::table($this->economics_table)->where('id', $value)->delete();
                }
            } elseif(is_numeric($id)){
                $delete = DB::table($this->economics_table)->where('id', $id)->delete();
            }else{
                return false;
            }

            return $delete;
        }
        
    }


    public function engagement_analysis_details($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->economics_table)->select('id', 'name', 'designation', 'hours', 'rate')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->get();
    }


    public function save_engagement_analysis($name, $designation, $hours, $rate, $deal_id, $client_id, $company_id)
    {
        $save = DB::table($this->economics_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'name'=>ucwords($name), 'designation'=>ucfirst($designation), 'hours'=>$hours, 'rate'=>$rate]);

        return $save;
    }

    public function proposed_budget_information($deal_id, $client_id, $company_id)
    {
        $details = DB::table($this->proposed_budget_table)->select('proposed_amount', 'agreed_fee')->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        return $details->first();
    }


    public function save_proposed_budget($proposed_amount, $agreed_fee, $deal_id, $client_id, $company_id)
    {
        $check = DB::table($this->proposed_budget_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id]);
        $count = $check->count();

        if ($count > 0) {
            return $this->update_proposed_budget($deal_id, $client_id, $company_id, $proposed_amount, $agreed_fee);
        }
        else
        {
            return $this->new_proposed_budget($deal_id, $client_id, $company_id, $proposed_amount, $agreed_fee);
        }
    }


    protected function new_proposed_budget($deal_id, $client_id, $company_id, $proposed_amount, $agreed_fee)
    {
        $save = DB::table($this->proposed_budget_table)->insert(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id, 'proposed_amount'=>$proposed_amount, 'agreed_fee'=>$agreed_fee]);
        return $save;
    }


    protected function update_proposed_budget($deal_id, $client_id, $company_id, $proposed_amount, $agreed_fee)
    {
        $update = DB::table($this->proposed_budget_table)->where(['deal_id'=>$deal_id, 'client_id'=>$client_id, 'company_id'=>$company_id])->update(['proposed_amount'=>$proposed_amount, 'agreed_fee'=>$agreed_fee]);

        return $update;
    }
}
