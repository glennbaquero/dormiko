<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselTag extends Model
{
    protected $guarded = [];

    const MINIMAL_COLUMN = [
    	'id',
    	'name',
    ];

    public function carousels() {
        return $this->belongsToMany(Carousel::class, 'carousel_carousel_tag_pivot', 'carousel_id', 'carousel_tag_id');
    }
}
