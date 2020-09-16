<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CorpHRM;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Response;
use Validator;
use Illuminate\Support\Facades\Input;

trait GenerateCodeTrait
{

    public function generate_code($table,$length,$row) 
    {
        $code = 0;
        $check = true;
        while ($check) {
            $code = $this->generate_new_code($length);
            $check = $this->check_code($table, $code, $row);
        } 
        return $code;
    }

    private function generate_new_code($length) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function check_code($table, $code, $row) 
    {
            $p_exist = DB::select(DB::raw("SELECT * FROM $table WHERE $row = '$code' "));
        if (!empty($p_exist)) {
            $result = true;
        }else{
            $result = false;
        }
        
        
        return $result;
    }
}
