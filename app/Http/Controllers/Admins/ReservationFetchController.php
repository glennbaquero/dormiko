<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FetchController;

use App\Reservation;
use App\Building;
use App\Room;

class ReservationFetchController extends FetchController
{
	/**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Reservation;
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
        
       if($this->request->filled('type')) {
           $query = $query->where('building_id', $this->request->input('type'));
        }

        if(auth('admin')->user()->type === 1) {
            $query = $query->where('building_id', auth('admin')->user()->building_id);
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
                'message' => $item->message,
                'status' => $item->status,
                'name' =>  $item->user ? $item->user->userDetail->firstname.' '.$item->user->userDetail->lastname : '',
                'movein' => $item->movein->format('M d, Y'),
                'moveout' => $item->moveout ? $item->moveout->format('M d, Y') : '-',
                'created_at' => $item->created_at->format('M d, Y'),
                'actions' => array(
                    'view' => $item->renderView(),
                    'deny' => $item->reservationDeny()
                )
            ));
        }

        return $result;
    }

    public function fetchItem($id = null)
    {
        $item = null;

        if ($id) {
            $item = Reservation::find($id);
            $item->user = $item->user->userDetail;
            $item->unit_no = $item->building->rooms;
            $item->building = $item->building;
            $item->selected_room_type = $item->room_type;
            $item->room_type = $item->roomType();
        }

        // $item->buildings = Building::with('rooms')->get();

        return response()->json([
            'item' => $item,
        ]);
    }
}
