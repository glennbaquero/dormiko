<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Contract;
use Carbon\Carbon;

class BillingRentFetchController extends FetchController
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
                'tenant_id' => $item->user->userDetail->tenant_id,
                'name' => $item->user->userDetail->firstname.' '. $item->user->userDetail->lastname,
                'invoices' => $item,
                'duration' => $item->duration_from->format('Y-m-d').' - '.$item->duration_to->format('Y-m-d'),
                'rentBills' => $this->rentalBill($item->billing_rents ? $item->billing_rents : ''),
                'rental_fee' => $item->room ? $item->room->price_range_from : '',
                'note' => $item->user->reservation->first()->message,
                'today' => date('Y-m-d'),

                // 'actions' => array(
                //     'view' => $item->printInvoice(),
                // )

                
            ));
        }

        return $result;
    }

    public function rentalBill($rent)
    {
    	$array = [];
    	foreach($rent as $extracted) {
    		$array[] = [
                'invoice' => $extracted->invoice,
    			'date' => $extracted->due_date->format('M d, Y'),
    			'total' => $extracted->penalty + $extracted->invoice->amount,
    			'label' => $extracted->due_date->format('Y-m-d') > date('Y-m-d') ? 'Unpaid' : 'Overdue',
    			'stylelabel' => $extracted->due_date->format('Y-m-d') > date('Y-m-d') ? 'btn-primary btn-flat btn-xs' : 'btn-danger btn-flat btn-xs',
                'actions' => array(
                    'paymenturl' => $extracted->invoice->payment(),
                    'export' => $extracted->invoice->payment(),
                    'print' => $extracted->invoice->printInvoice(),
                )
    		];
    	}

    	return $array;
    }

    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {

           

            $item = BillingRent::find($id);
            $item->name = $item->contract->user->userDetail->firstname.' '.$item->contract->user->userDetail->lastname;
            $item->tenant_id = $item->contract->user->userDetail->tenant_id;
            $item->duration = $item->contract->duration_from->format('M d, Y').' - '.$item->contract->duration_to->format('M d, Y');

            $due_date_arr = [];
            $start = $item->contract->duration_from->month;
            $end = $item->contract->duration_to->month;  

            $item->duedate = $item->due_date->format('M d, Y');
            $item->user = $item->contract->user;
            $item->note = $item->contract->user->reservation->message;
            $item->amount =  $item->contract->room->price_range_from + $item->penalty;
            $item->amount =  $item->invoice->amount;

            if(empty($item->user->invoices)){
                $item->amount = "";
                $item->status = 0;
            } else {
                $item->status = $item->invoice->status;
                $item->reference_code = $item->invoice->reference_code;
                $item->status = 1;
            }
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
