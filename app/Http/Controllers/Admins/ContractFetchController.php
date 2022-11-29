<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FetchController;

use App\Contract;
use App\Room;
use App\User;
use App\UserDetail;
use Carbon\Carbon;

class ContractFetchController extends FetchController
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
        if ($this->request->filled('search')) {
            $search = UserDetail::where('tenant_id', $this->request->input('search'))
                                ->orWhere('firstname', $this->request->input('search'))
                                ->orWhere('lastname', $this->request->input('search'))
                                ->first();
            $this->request['search'] = $search->user->id;
            $user = User::find($this->request->input('search'));
            $this->request['search'] = $user->id;
            $ids = $this->class::search($this->request->input('search'))->get()->pluck('id')->toArray();
            $query = $query->whereIn('id', $ids);
        }
        
        if($this->request->filled('status')) {
           $query = $query->where('status',  $this->request->input('status'));
        }

        if($this->request->filled('type')) {
           // $query = $query->whereHas('utility_id',  $this->request->input('type'));
           $query = $query->whereHas('room', function($query) {
                $query->where('building_id', $this->request->input('type'));
            });
        }

        if($this->request->filled('room')) {
           $query = $query->where('room_id',  $this->request->input('room'));
        }
        
        if($this->request->filled('duration_from')) {
            $now = Carbon::now();

            $monthName = date('F', mktime(0, 0, 0, $this->request->input('duration_from'), 10));

            if($this->request->input('duration_from') > 12) {
                $newYearPST = Carbon::parse('first day of January'. $this->request->input('duration_from'));
                $lastDayOfYear = Carbon::parse('last day of December'. $this->request->input('duration_from'));
            } else {
                $newYearPST = Carbon::parse('first day of'.$monthName . Carbon::now()->year);
                $lastDayOfYear = Carbon::parse('last day of'.$monthName . Carbon::now()->year);
            }
                $query = $query->whereBetween('duration_from', [$newYearPST, $lastDayOfYear]);
            
        }

        if(auth('admin')->user()->type === 1) {
            $query = $query->whereHas('room', function($query) {
                $query->where('building_id', auth('admin')->user()->building_id);
            });

        }
        
        
        return $query->groupBy('user_id');
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
                'room_id' => $item->room ? $item->room->id : '',
                'unit' => $item->room ? $item->room->unit_name : '',
                'room' => $item->room,
                'status_label' => $item->renderStatusLabel(),
                'status' => $item->status,
                'status_class' => $item->renderStatusClass(),
                'building' => $item->room ? $item->room->building->name : '',
                'name' => $item->user->userDetail->firstname.' '.$item->user->userDetail->lastname,
                'duration_from' => $item->duration_from->format('M d, Y'),
                'duration_to' => $item->duration_to ? $item->duration_to->format('M d, Y') : null,
                'created_at' => $item->created_at->format('M d, Y'),
                'contract_count' => $item->count(),
                'user' => $item->user,
                'actions' => array(
                    'view' => $item->renderView(),
                    'evict' => $item->evictRoute(),
                    'restore' => $item->restoreTenant(),
                    'edit' => $item->editContract(),
                )
            ));
        }

        return $result;
    }

    public function fetchRoom($items) 
    {
        $result = [];

        foreach($items as $item) {
            array_push($result, array(
                'room' => $item->room,
            ));
        }

        return $result;
    }

    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {
            $item = Contract::find($id);
            $item->extracted_date_from = $item->duration_from->format('M d, Y');
            $item->extracted_date_to = $item->duration_to ? $item->duration_to->format('M d, Y') : null;
            $item->userinfo = $item->user->userDetail;
            $item->birthdate = $item->user->userDetail->birthdate ? $item->user->userDetail->birthdate->format('M d, Y') : '';
            $item->lists = $item->user->reservationlists;
            $item->room = $item->room;
            $item->reservation = $item->user->reservation;
            $item->move_in = $item->user->reservation->movein->format('Y-m-d');
            $item->move_out = $item->user->reservation->moveout ? $item->user->reservation->moveout->format('Y-m-d') : '';
            $item->rooms = Room::all();
            $item->building = $item->room->building;
        }

        return response()->json([
            'item' => $item,
        ]);
    }
}
