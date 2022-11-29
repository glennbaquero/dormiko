<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutUsContent extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];

    public function renderView()
    {
    	return route('about.edit', $this->id);
    }
}

