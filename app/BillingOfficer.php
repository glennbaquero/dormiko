<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ActivityLogTrait;

use Illuminate\Support\Facades\Password;
use Route;
use App\Helpers;

class BillingOfficer extends Authenticatable
{
	use Notifiable, ActivityLogTrait;
    protected $guarded = [];

    public function building()
    {
    	return $this->belongsTo(Building::class);
    }
    
     public function renderName() {
        return ucwords($this->firstname . ' ' . $this->lastname);
    }
}
