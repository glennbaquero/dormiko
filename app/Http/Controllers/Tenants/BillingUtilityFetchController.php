<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Contract;

class BillingUtilityFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Contract;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
    	if(auth()->check()) {
	    	$query = $query->where('user_id', auth()->user()->id);
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
                'utilities' => $this->billingRent($item->billing_utilities),
                'note' => $item->user->reservation->first()->message,
                'today' => date('Y-m-d'),
                
            ));
        }

        return $result;
    }

    public function billingRent($utilities)
    {
    	$array = [];
    	foreach ($utilities as $utility) {
            $array[] = [
                'invoice' => $utility->invoice,
                'duration_start' => $utility->duration_start->format('M d, Y'),
                'duration_end' => $utility->duration_end->format('M d, Y'),
                'due_date' => $utility->due_date->format('M d, Y'),
                'duration' => $utility->duration_start->format('M d, Y'). '-'. $utility->duration_end->format('M d, Y'),
                'item' => $utility->utility->name,
                'amount' => $utility->invoice->amount,
                'label' => $utility->due_date->format('Y-m-d') > date('Y-m-d') ? 'Unpaid' : 'Overdue',
                'stylelabel' => $utility->due_date->format('Y-m-d') > date('Y-m-d') ? 'btn-primary btn-flat btn-xs' : 'btn-danger btn-flat btn-xs',
                'actions' => array(
                    'paymenturl' => $utility->invoice->payment(),
                    'print' => $utility->invoice->printInvoice(),
                )
            ];   
        }

    	return $array;
    }
}
