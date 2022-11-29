<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Page;

class PageFetchController extends FetchController
{ 
	/**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Page;
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

        // if($this->request->has('archive')) {
        //     $ids = $query->onlyTrashed()->pluck('id')->toArray();
        //     $query = $query->onlyTrashed()->whereIn('id', $ids);
        // }

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
                'slug' => $item->slug,
                'created_at' => $item->created_at->format('M d, Y (H:i:s)'),
                'deleted' => $item->deleted_at ? true : false,
                
                'actions' => array(
                    'view' => $item->renderView(),
                    'delete' => $item->renderDelete(),
                    'restore' => $item->renderRestore(),
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
            $item = Page::find($id);
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
