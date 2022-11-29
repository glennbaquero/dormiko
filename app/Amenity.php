<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ActivityLogTrait;

class Amenity extends Model
{
    protected $guarded = [];

    use ActivityLogTrait;

    public function buildings()
    {
    	return $this->belongsTo(Building::class);
    }

    public function renderName() {
        return $this->name;
    }
}
