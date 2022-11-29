<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\BillingOfficer;

class BillingOfficerFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new BillingOfficer;
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
                'created_at' => $item->created_at->format('M d, Y'),

                'actions' => array(
                    // 'view' => $item->renderView(),
                    // 'deny' => $item->reservationDeny()
                )
            ));
        }

        return $result;
    }

    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {
        	$item = BillingOfficer::find($id);
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
