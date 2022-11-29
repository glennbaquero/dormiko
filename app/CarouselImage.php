<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselImage extends Model
{
    protected $guarded = [];


    public function carousel() {
        return $this->belongsTo(Carousel::class);
    }
    
    public function renderFilePath($column = 'image_path') {
        $path = null;
        if ($this[$column]) { $path = asset('storage/' . $this[$column]); }
        return $path;
    }

    public function update_carousel($path){
        $this->update(['image_path'=>$path]);
    }
    
    public function renderPath($column = 'image_path') {
        $path = null;
        if ($this[$column]) { $path = asset('storage/' . $this[$column]); }
        return $path;
    }

    public function renderDelete() {
        return route('carousel.destroy', $this->id);
    }
}
