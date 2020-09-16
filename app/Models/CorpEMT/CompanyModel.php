<?php 
namespace App\Models\CorpEMT;
use Illuminate\Database\Eloquent\Model;
use DB;

class CompanyModel extends Model
{

    protected $table = 'company';

    public function add_company($name, $email)
    {
        $company     = DB::table($this->table)->where('name', $name);
        $count         = $company->count();
        
        if ($count < 1) {
            $save = DB::table($this->table)->insert(['name'=>ucwords($name), 'email'=>strtolower($email)]);
            return $save;
        }
        else
        {
            return 'exist';
        }
    }



    public function list_company()
    {
        $company = DB::table($this->table)->select('id', 'name')->get();
        return $company;
    } 
}
