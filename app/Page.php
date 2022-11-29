<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Scout\Searchable;
use App\Traits\ActivityLogTrait;
// 
use App\Building;
use App\AboutUsContent;
use App\Amenity;

class Page extends Model
{
 	use Searchable, ActivityLogTrait;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    protected $request;

    const MINIMAL_COLUMN = [
        'id', 
        'name', 'slug',
    ];

    /**
     * @TNT Search
     */
    public $asYouType = true;
    
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }

    /**
     * @Relationships
     */
    public function page_items() {
        return $this->hasMany(PageItem::class, 'page_id');
    }

    /**
     * @Getters
     */
    
    /**
     * Assemble Page Data
     * @return array Page Data
     */
    public function getData($request = null) {

        $this->request = $request;

        $data = [
            'page' => $this,
            'item' => $this->getPageItems(),
            'view' => "frontend.{$this->slug}"
        ];

        $data = $this->getExtraPageData($data);

        return $data;
    }

    /**
     * @Methods
     */
    public static function store($request, $item = null) {

        $vars = $request->only(['name']);
        $vars['slug'] = Helpers::slugify($request->input('slug'));

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

    /**
     * @Helpers
     */

    /**
     * Get additional page data
     * @param  App\Page $page
     * @return array
     */
    public function getExtraPageData($data) {
        $arr = [];

        $amenities = \DB::table('amenities')
            ->groupBy('name')
            ->get();

        switch($this->slug) {
            case 'home':
                    $data['view'] = "pages.home";
                    $data['amenities'] = $amenities;
                    $data['buildings'] = Building::with('images')->whereHas('rooms', function($query) {
                        // $query->groupBy('room_type');
                        $query->distinct();
                    })->get();
                    $data['carousels'] = Carousel::with('images')->whereHas('tags', function($query){
                                            $query->where('name', 'home');
                                        })->get();
                break;
            case 'about':
                   $data['view'] = "pages.about";
                   $data['contents'] = AboutUsContent::all();
                   break;
            case 'gallery':
                    $data['view'] = "pages.gallery";
                    $data['galleries'] = Gallery::with('images')->get();
                break;
        }

        return array_merge($data, $arr);
    }

    /**
     * Rename Properties for easier access
     * @return stdClass       Collection of modified page items
     */
    public function getPageItems() {

        $item = new \stdClass();

        foreach($this->page_items as $pageItem) {
            $item->{$pageItem->slug . 'ID'} = $pageItem->id;

            if($pageItem->content) {
                switch ($pageItem->type) {
                    case PageItem::FILE:
                            $content = asset('storage/' . $pageItem->content);
                        break;
                    
                    default:
                            $content = $pageItem->content;
                        break;
                }

                $item->{$pageItem->slug} = $content;
            }
        }

        return $item;
    }

    /**
     * @Renders
     */
    public function renderName() {
        return $this->name;
    }

    public function renderPageView() {
        switch($this->slug) {
            default:
                    $view = 'frontend.' . $this->slug;
                break;
        }

        return $view;
    }

    public function renderView() {
        return route('pages.edit', $this->id);
    }

    public function renderDelete() {
        return route('pages.destroy', $this->id);
    }

    public function renderRestore() {
        return route('pages.restore', $this->id);
    }
}
