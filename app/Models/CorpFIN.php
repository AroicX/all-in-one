<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CorpFIN extends Model
{

    public static function retrieve_fxn1($table,$row,$query)
    {
        $query = DB::select(DB::raw("SELECT * FROM $table WHERE $row = '$query' "));
        return $query;
    }

    public static function insert_retrieveid($table,$data)
    {
        $query = DB::table($table)->insertGetId($data); 
        return $query;
    }

    public static function retrieve_fxn2($table,$row1,$row2,$query1,$query2)
    {
        $query = DB::select(DB::raw("SELECT * FROM $table WHERE $row1 = '$query1' AND $row2 = '$query2' "));
        return $query;
    }
    public static function insert_fxn($table,$data)
    {
        $query = DB::table($table)->insert($data);
        return $query;
    }

    public static function update_fxn($table,$where,$data)
    {
        //$query = DB::update( DB::raw("UPDATE activations SET updated_at =  '$today' WHERE token = '$token' ")); 
        $query = DB::table($table)->where($where)->update($data);
    }

    public static function delete_fxn($where)
    {
        $query = DB::table($table)->where($where)->delete();
    }

}
