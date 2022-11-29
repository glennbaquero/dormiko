<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Invoice;
use Carbon\Carbon;

class BillingHistoryFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Invoice;
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
                // 'tenant_id' => $item->contract->user->userDetail->tenant_id,
                // 'name' => $item->contract->user->userDetail->firstname.' '. $item->contract->user->userDetail->lastname,
                // 'invoices' => $item->contract->user->invoices,
                // 'billingutilities' => $item->contract->billing_utilities,
                // 'invoices' => $item->contract->user->invoices,
                // 'duration' => $item->contract->duration_from->format('M d, Y').' - '.$item->contract->duration_to->format('M d, Y'),
                // 'due_date' => $item->due_date->format('M d, Y'),
                // 'rental_fee' => $item->contract->room->price_range_from,
                // 'total' => $item->penalty+$item->contract->room->price_range_from,
                // 'penalty' => $item->penalty,
                // 'note' => $item->contract->user->reservation->message,
                // 'status' => $item->status,
                'created_at' => $item->created_at->format('M d, Y'),
                'billingrents' => $item->billing_rent,

                'actions' => array(
                    // 'view' => $item->renderView(),
                    // 'deny' => $item->reservationDeny()
                )
            ));
        }

        return $result;
    }
}
