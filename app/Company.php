<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    public function corpfinInvoiceGroups()
    {
        return $this->hasMany('App\CorpfinInvoiceGroup');
    }

    /**
     * A company has many customers /// using status
     * @param $status
     * @return mixed
     */
    public function clientsWithStatus($status)
    {
        return $this->hasMany('App\CorpfinCustomer')->where('status', $status);
    }

    /**
     * A company has many transaction partners
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transPartners()
    {
        return $this->hasMany('App\CorpFinTranPartner');
    }

    /**
     * A company has many customers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany('App\CorpfinCustomer');
    }

    /**
     * Registered VAT values for the company
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vats()
    {
        return $this->hasMany('App\Vat');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function whts()
    {
        return $this->hasMany('App\Wht');
    }

    /**
     * Company products
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function corpFinProducts()
    {
        return $this->hasMany('App\CorpFinProduct');
    }

    /**
     * Company services
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function corpFinServices()
    {
        return $this->hasMany('App\CorpFinService');
    }

    /**
     * Company trancastion currency
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Country');
    }

    public function invoice_group(){
        return $this->hasMany('App\Model\CorpFIN\InvoiceGroup');
    }

    public function order(){
        return $this->hasMany('App\inventory\Order');
    }

    public function markup(){
        return $this->hasOne('App\Models\CorpFIN\Markup');
    }
     public function product_line(){
        return $this->hasMany('App\inventory\ProductLine');
    }
}
