<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ActivityLogTrait;

class Utility extends Model
{
    use ActivityLogTrait;
    protected $guarded = [];

    public function billingutility()
    {
    	return $this->hasMany(BillingUtility::class);
    }
    
    public function renderName() {
        return $this->name;
    }
}
