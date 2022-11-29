<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\User;
use Carbon\Carbon;

class UnpaidBillFetchController extends FetchController
{
	/**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new User;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
    	$query = auth()->user()->contract();
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
        	$rent = $item->billing_rents->where('status', 0)->first();
        	$utilities = $item->billing_utilities->where('status', 0);
            array_push($result, array(
            	'rent' => $rent,
                'rent_status' => $rent ? ($rent->due_date->format('Y-m-d') > date('Y-m-d') ? 'Unpaid' : 'Overdue') : 'All bills are paid',
                'rent_duedate' => $rent ? $rent->due_date->format('M d, Y') : 'All bills are paid',
                'utilities' => $this->utility($utilities),
                'show' => $rent ? true : false,

                'actions' => array(
                    'view' => $rent ? $rent->invoice->payment() : '',
                    // 'paybill' => $utilities->invoice->payment()
                )
            ));
        }

        return $result;
    }

    public function utility($utilities)
    {
    	 $result = [];

        foreach($utilities as $utility) {
            array_push($result, array(
            	'utilities' => $utility,
            	'name' => $utility->utility->name,
                'utility_status' => $utility->due_date->format('Y-m-d') > date('Y-m-d') ? 'Unpaid' : 'Overdue',
                'utility_duedate' => $utility->due_date->format('M d, Y'),
                'actions' => array(
                    'pay' => $utility->invoice->payment()
                )
            ));
        }

        return $result;
    }
}
