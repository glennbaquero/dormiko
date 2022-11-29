<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ActivityLogTrait;

class Gallery extends Model
{
    use ActivityLogTrait;
    protected $guarded = [];
    protected $dates = ['created_at'];

    public function images()
    {
    	return $this->hasMany(GalleryImage::class);
    }

    public function renderView()
    {
    	return route('gallery.edit', $this->id);
    }

    public function renderDestroy()
    {
        return route('gallery.destroy', $this->id);
    }

    public function renderName() {
        return $this->header;
    }
}
