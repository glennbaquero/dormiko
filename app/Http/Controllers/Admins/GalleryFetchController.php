<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Gallery;

class GalleryFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Gallery;
    }
    
    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
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
                'header' => $item->header,
                'created_at' => $item->created_at->format('M d, Y (H:i:s)'),
                'actions' => array(
                    'view' => $item->renderView(),
                    'destroy' => route('gallery.destroy', $item->id),
                )
            ));
        }

        return $result;
    }

    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {
            // $item = Page::withTrashed()->find($id);
            $item = Gallery::find($id);
            $images = [];
            // $item->images = $item->images;
            foreach($item->images as $img) {
                array_push($images, array(
                    'url' => $img->renderDestroy(),
                    'images' => $img,
                ));
            }

            $item->image_list = $images;
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
