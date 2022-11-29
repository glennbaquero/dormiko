<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingBanner extends Model
{
	protected $guarded = [];
    public function building()
    {
    	return $this->belongsTo(Building::class);
    }
}
