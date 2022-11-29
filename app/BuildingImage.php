<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingImage extends Model
{
    protected $guarded = [];

    public function building()
    {
    	return $this->belongsTo(Building::class);
    }

    public function renderImage()
    {
    	return '/storage/'.$this->path;
    }
}
