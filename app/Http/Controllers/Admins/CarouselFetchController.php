<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Carousel;
use App\CarouselTag;

class CarouselFetchController extends FetchController
{
	/**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Carousel;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        if ($this->request->filled('search')) {
            $ids = $this->class::search($this->request->input('search'))->get()->pluck('id')->toArray();
            $query = $query->whereIn('id', $ids);
        }
        
        if ($this->request->filled('tag')) {
            $query = $query->whereHas('tags', function($query) {
                $query->where('id', $this->request->input('tag'));
            });
        }

        return $query;
    }

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */
    public function formatData($items)
    {
        $result = [];

        foreach($items as $item) {
            array_push($result, array(
                'id' => $item->id,
                'name' => $item->name,
                'tag_list' => $item->renderTagList(),
                'created_at' => $item->created_at->format('M d, Y (H:i:s)'),

                'actions' => array(
                    'view' => $item->renderView()
                )
            ));
        }

        return $result;
    }

    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {
            // $item = Carousel::withTrashed()->find($id);
            // $item = Carousel::find($id);
            $item = Carousel::find($id);
            $item->tags = $item->tags()->pluck('id')->toArray();
            $formatted_images = [];
            
            foreach($item->images as $image){
                $formatted_images[] = [
                    'id' => $image->id,
                    'path' => $image->renderFilePath(),
                    'url' => $image->renderDelete(),
                ];
            }

            $item->photos = $formatted_images;
        }

        $tags = CarouselTag::all();

        return response()->json([
            'item' => $item,
            'tags' => $tags
        ]);
    }
}
