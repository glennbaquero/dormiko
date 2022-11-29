<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\Invoice;
use Carbon\Carbon;

class InvoiceFetchController extends FetchController
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
        if(auth('admin')->user()->type === 1) {
            $query = $query->whereHas('billing_rent', function($query) {
                $query->whereHas('contract', function($contract) {
                    $contract->whereHas('room', function($room) { 
                        $room->where('building_id', auth('admin')->user()->building_id);
                    }); 
                });
            });
        }

        return $query->where('status', 1);
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
  
            if($item->billing_rent) {
                array_push($result, array(
                    'created_at' => $item->created_at->format('M d, Y'),
                    'type' => 'Rent',
                    'billingrent' => $item->billing_rent,
                    'billingutility' => $item->billing_utility,
                    'tenant_id' => $item->user->userDetail->tenant_id,
                    'name' => $item->user->userDetail->firstname.' '.$item->user->userDetail->lastname,
                    'duration' => $item->billing_rent->contract->duration_from->format('M d, Y').' - '.$item->billing_rent->contract->duration_to->format('M d, Y'),
                    'payment_date' => $item ? $item->payment_date->format('M d, Y') : '',
                    'due_date' => $item->billing_rent->due_date->format('M d, Y'),
                    'note' => $item->user->reservation[0]->message,
                    'amount' => $item->billing_rent->contract->room->price_range_from,
                    'reference_code' => $item->reference_code,
                    'penalty' => $item->billing_rent->penalty ? $item->billing_rent->penalty : '0.00',
                    'payment_method' => $item->payment_method === 0 ? 'iPay88' : ($item->payment_method === 1 ? 'Paypal' : ($item->payment_method === 2 ? 'Bank Deposit' : ($item->payment_method === 3 ? 'Cash' : ''))) ,
                    'actions' => array(
                        'view' => $item->renderView(),
                        // 'deny' => $item->reservationDeny()
                    )
                ));
            } else {
                array_push($result, array(
                    'created_at' => $item->created_at->format('M d, Y'),
                    'billingrent' => $item->billing_utility,
                    'tenant_id' => $item->user->userDetail->tenant_id,
                    'name' => $item->user->userDetail->firstname.' '.$item->user->userDetail->lastname,
                    'duration' => $item->billing_utility->contract->duration_from->format('M d, Y').' - '.$item->billing_utility->contract->duration_to->format('M d, Y'),
                    'type' => $item->billing_utility->utility->name,
                    'due_date' => $item->billing_utility->due_date->format('M d, Y'),
                    'note' => $item->user->reservation[0]->message,
                    'amount' => $item->billing_utility->amount,
                    'reference_code' => $item->reference_code,
                    'penalty' => $item->billing_utility->penalty ? $item->billing_utility->penalty : '0.00',
                    'payment_method' => $item->payment_method === 0 ? 'iPay88' : ($item->payment_method === 1 ? 'Paypal' : ($item->payment_method === 2 ? 'Bank Deposit' : ($item->payment_method === 3 ? 'Cash' : ''))) ,
                    'actions' => array(
                        'view' => $item->renderView(),
                        // 'deny' => $item->reservationDeny()
                    )
                ));
            }
            
        }

        return $result;
    }


    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {
            $item = Invoice::find($id);
            $item->tenant_id = $item->user->userDetail->tenant_id;
            $item->name = $item->user->userDetail->firstname.' '.$item->user->userDetail->lastname;
            $item->note = $item->user->reservation[0]->message;
            $item->payment_method = $item->payment_method;
            if($item->billing_rent) {
                $item->duedate = $item->billing_rent->due_date->format('M d, Y');
                $item->duration = $item->billing_rent->contract->duration_from->format('M d, Y').' - '.$item->billing_rent->contract->duration_to->format('M d, Y');
                $item->status = $item->billing_rent->status;
                $item->amount = $item->billing_rent->contract->room->price_range_from + $item->billing_rent->penalty;
            } else {
                $item->duedate = $item->billing_utility->due_date->format('M d, Y');
                $item->duration = $item->billing_utility->duration_start->format('M d, Y').' - '.$item->billing_utility->duration_end->format('M d, Y');
                $item->status = $item->billing_utility->status;
                $item->amount = $item->billing_utility->amount + $item->penalty;
            }
         //    $item->duration = $item->billing_rent->contract->duration_from->format('M d, Y').' - '.$item->billing_rent->contract->duration_to->format('M d, Y');
         //    $item->status = $item->billing_rent->status;
	        // $item->duedate = $item->billing_rent->due_date->format('M d, Y');
	        // $item->amount = $item->billing_rent->contract->room->price_range_from + $item->billing_rent->penalty;
	        $item->reference_code = $item->reference_code;
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
