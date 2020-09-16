<?php
 namespace App\Models\CorpEMT;

use Illuminate\Database\Eloquent\Model;
use DB;

class TeamModel extends Model
{

    protected $team_table = 'emt_team';

    public function assign_team_member($staff, $client_id, $company_id)
    {
        $save = DB::table($this->team_table)->insert(['fullname'=>$fullname, 'company_id'=>$company_id]);
        return $save;
    }



    public function remove_team_member($id)
    {
        $delete = DB::table($this->team_table)->where('id', $id)->delete();
    }



    public function list_team_members($company_id)
    {
        $team = DB::table($this->team_table)->select('name')->where('company_id', $company_id)->get();
    }
}
