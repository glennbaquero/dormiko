<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $guarded = [];

    public function gallery()
    {
    	return $this->belongsTo(Gallery::class);
    }

    public function renderDestroy()
    {
        return route('gallery.destroy.image', $this->id);
    }

}
