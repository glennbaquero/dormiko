<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\PageItem;
use App\Page;

class PageItemFetchController extends FetchController
{
	/**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new PageItem;
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

        if ($this->request->filled('type')) {
            $query = $query->where('type', $this->request->input('type'));
        }

        if($this->request->filled('page_id')) {
            $query = $query->whereHas('page', function($query) {
                return $query->where('id', $this->request->input('page_id'));
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
                'page_name' => $item->renderRelationshipName('name'),
                'page_slug' => $item->renderRelationshipName(),
                'slug' => $item->slug,
                'type_label' => $item->renderTypeLabel(),
                'type_class' => $item->renderTypeClass(),
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
            // $item = PageItem::withTrashed()->find($id);
            $item = PageItem::find($id);
            $item->file = $item->renderFilePath();
        }

        $types = PageItem::getTypes();

        $pages = Page::select(Page::MINIMAL_COLUMN)->get();

        return response()->json([
            'item' => $item,
            'pages' => $pages,
            'types' => $types,
        ]);
    }
}
