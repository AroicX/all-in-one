<?php
/**
 * Created by PhpStorm.
 * User: dubem
 * Date: 1/14/17
 * Time: 11:49 PM
 */

namespace App\Services\CorpTax;


use App\Repository\CorpTax\CITRegistry;

class CITManager
{
    /**
     * @var CITRegistry
     */
    private $CITRegistry;

    /**
     * CITManager constructor.
     * @param CITRegistry $CITRegistry
     */
    public function __construct(CITRegistry $CITRegistry)
    {

        $this->CITRegistry = $CITRegistry;
    }

    /**
     *
     */
    public function computeProfitBeforeTax()
    {

    }

    /**
     *
     */
    public function computeCapitalAllowance()
    {

    }
}
