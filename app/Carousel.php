<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Scout\Searchable;
use App\Traits\ActivityLogTrait;

class Carousel extends Model
{
	use Searchable, ActivityLogTrait;
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function images() {
        return $this->hasMany(CarouselImage::class);
    }

    public function getImage($number)
    {
        if ($this->images()->count()) {
            return '/storage/' . $this->images()->orderBy('order_column', 'asc')->skip($number - 1)->first()->path;
        }
    }

    public static function store($request, $item = null) {
        $vars = $request->only(['name', 'content']);

        if(!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('carousel-images', 'public');

                $item->images()->create(['image_path'  => $path]);
            }
        }
        
        $item->tags()->sync($request->input('tags'));

        return $item;

    }

    public function removeImage() {
        // return route('carousel.image', $this->images());
    }
    
    /**
     * @TNT Search
     */
    public $asYouType = true;
    
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /*
     * Renders
     */


    public function renderFilePath($column = 'image_path') {
        $path = null;
        if ($this[$column]) { $path = asset('storage/' . $this[$column]); }
        return $path;
    }

    public function tags() 
    {
        return $this->belongsToMany(CarouselTag::class, 'carousel_carousel_tag_pivot', 'carousel_tag_id', 'carousel_id');
    }

    public function renderTags() {
        return htmlentities(json_encode(
            $this->tags->pluck('name')
        ));
    }

    public function renderTagList() {
        return implode(', ', $this->tags->pluck('name')->toArray());
    }

    public function renderShortContent() {
        if($this->content) {
            return str_limit($this->content, 85);
        }
    }

    public function renderName() {
        return $this->name;
    }

    public function renderView() {
    	return route('carousel.edit', $this->id);
    }

    public function renderDelete() {
        return route('carousel.destroy', $this->id);
    }

    public function renderRestore() {
        return route('carousel.restore', $this->id);
    }
}
