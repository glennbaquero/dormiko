<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Building;

class BuildingFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Building;
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
                // 'tenant_id' => $item->user->userDetail->tenant_id,
                // 'room_id' => $item->room->id,
                // 'unit' => $item->room->unit_name,
                // 'status_label' => $item->renderStatusLabel(),
                // 'status_class' => $item->renderStatusClass(),
                // 'building' => $item->room->building->name,
                // 'name' => $item->user->userDetail->firstname.' '.$item->user->userDetail->lastname,
                // 'duration_from' => $item->duration_from->format('M d, Y'),
                // 'duration_to' => $item->duration_to->format('M d, Y'),
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
            $item = Building::find($id);
        }

        return response()->json([
            'item' => $item,
        ]);
    }

    public function fetchPositions(Request $request)
    {
        $result = Building::getPositionByAddress($request->input('location'));

        return response()->json($result);
    }
}
