<?php 
namespace App\Models\CorpEMT;

use Illuminate\Database\Eloquent\Model;
use DB;

class SettingsModel extends Model
{

    protected $table = 'emt_settings';

    public function save_setting($title, $identity, $company_id)
    {
        $save = DB::table($this->table)->insert(['company_id'=>$company_id, 'title'=>ucwords($title), 'identity'=>$identity]);
        return $save;
    }

    public function remove_setting($ids)
    {
        foreach ($ids as $id) 
        {
            $delete = DB::table($this->table)->where('id', $id)->delete();
        }
        
        return $delete;
    }


    public function list_lead_sources($identity, $company_id)
    {
        $lead_sources = DB::table($this->table)->select('id', 'title')->where(['identity'=>$identity, 'company_id'=>$company_id]);

        return $lead_sources->get();

    }
}
