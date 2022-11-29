<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\FetchController;

use App\BillingRent;
use App\User;
use App\UserDetail;
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
        $this->class = new BillingRent;
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
            
            $search = UserDetail::where('tenant_id', $this->request->input('search'))
                                ->orWhere('firstname', $this->request->input('search'))
                                ->orWhere('lastname', $this->request->input('search'))
                                ->first();
            $this->request['search'] = $search->user->id;
            $user = User::find($this->request->input('search'));
            $this->request['search'] = $search->user->contract()->first()->id;
            // $query = $query->whereIn('user_id', $user);

            $ids = $this->class::search($this->request->input('search'))->get()->pluck('id')->toArray();
            $query = $query->whereIn('id', $ids);
        }
        
        if($this->request->filled('status')) {
           $query = $query->where('status',  $this->request->input('status'));
        }

        if($this->request->filled('due_date')) {
            $now = Carbon::now();

            $monthName = date('F', mktime(0, 0, 0, $this->request->input('due_date'), 10));

            if($this->request->input('due_date') > 12) {
                $newYearPST = Carbon::parse('first day of January'. $this->request->input('due_date'));
                $lastDayOfYear = Carbon::parse('last day of December'. $this->request->input('due_date'));
            } else {
                $newYearPST = Carbon::parse('first day of'.$monthName . Carbon::now()->year);
                $lastDayOfYear = Carbon::parse('last day of'.$monthName . Carbon::now()->year);
            }
                $query = $query->whereBetween('due_date', [$newYearPST, $lastDayOfYear]);
            
        }

        if(auth('admin')->user()->type === 1) {
            $query = $query->whereHas('contract', function($query) {
                $query->whereHas('room', function($room) {
                    $room->where('building_id', auth('admin')->user()->building_id);
                });
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
                'tenant_id' => $item->contract->user->userDetail->tenant_id,
                'name' => $item->contract->user->userDetail->firstname.' '. $item->contract->user->userDetail->lastname,
                'invoices' => $item->contract->user->invoices,
                'duration' => $item->contract->duration_from->format('M d, Y').' - '.$item->contract->duration_to->format('M d, Y'),
                'due_date' => $item->due_date->format('M d, Y'),
                'rental_fee' => $item->invoice->amount,
                'penalty' => $item->penalty,
                'reservation' => $item->contract->user->reservation,
                'today' => date('Y-m-d'),
                'label' => $item->due_date->format('Y-m-d') > date('Y-m-d') ? 'Unpaid' : 'Overdue',
                'status' => $item->status,
                'status_label' => $item->status == 1 ? 'Paid' : ($item->status == 2 ? 'Overdue' : ''),
                'total' => $item->penalty+($item->invoice ? $item->invoice->amount : 0),
                'created_at' => $item->created_at->format('M d, Y'),

                'actions' => array(
                    'view' => $item->renderView(),
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
            $item->amount =  $item->contract->room ? $item->contract->room->price_range_from + $item->penalty : 0;
            $item->invoice = $item->invoice;
            $item->status = $item->status;
            // $item->invoice->payment_date = Carbon::createFromFormat('Y-m-d', $item->invoice->payment_date)->format('Y-m-d');
            $item->payment_date = $item->invoice->payment_date ? $item->invoice->payment_date->format('Y-m-d') : null;
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
