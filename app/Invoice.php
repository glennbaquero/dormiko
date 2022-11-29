<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    protected $dates = ['updated_at', 'payment_date'];

    const UNPAID = 0;
    const PAID = 1;

    const IPAY88 = 0;
    const PAYPAL = 1;
    const BANKDEPOSIT = 2;
    const CASH = 3;
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function billing_rent()
    {
    	return $this->belongsTo(BillingRent::class);
    }

    public function billing_utility()
    {
    	return $this->belongsTo(BillingUtility::class);
    }

    public function renderView()
    {
    	return route('history.show', $this->id);
    }

    public function payment()
    {
        return route('checkout', $this->id);
    }

    public function printInvoice() 
    {
        return route('invoice', $this->id);
    }
}
