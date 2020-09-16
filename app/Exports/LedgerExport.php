<?php

namespace App\Exports;
 
use DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
 
class LedgerExport implements FromQuery, WithHeadings
{
    use Exportable;
 
    public function __construct($start, $end )
    {
        $this->start = $start;
        $this->end = $end;
    }
 
    public function query()
    {
        return DB::table('corpfin_generalledger')->where('company_id', $company->id)->whereBetween('date', [$this->start, $this->end])->orderBy('date', 'desc')->get();
    }
 
    /*public function headings() : array
    {
        return [
            'Id',
            'Title',
            'Body',
        ];
    }*/
}