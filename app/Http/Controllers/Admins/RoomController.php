<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequests;

use App\Room;
use App\Building;
use Storage;
use DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('buildings');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $floor = $_GET['floor'];
        return view('admin.rooms.create', compact('id', 'floor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequests $request)
    {
        DB::beginTransaction();
            $room = Room::create($request->except(['image']));

            if($request->hasFile('image')) {
                $image = $request->file('image')->store('room-images', 'public');
                $room->image = $image;
                $room->save();
            }
        DB::commit();

        return response()->json([
            'message' => 'You have successfully create a new room',
            // 'redirect' => $faq->renderView(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $floor = $_GET['floor'];
        DB::beginTransaction();
            $room = Room::find($id);
        DB::commit();

        return view('admin.rooms.edit', compact('room', 'floor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequests $request, $id)
    {
        DB::beginTransaction();
            $room = Room::find($id);

            // store new image
            if($request->hasFile('image')) {
                $image = $request->file('image')->store('room-images', 'public');
                $room->update(['image' => $image]);
            }
            $room->update($request->except(['image']));
        DB::commit();

        return response()->json([
            'message' => 'You have successfully update the '.$room->name,
            // 'redirect' => $faq->renderView(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
            $room = Room::find($id);
            $room->delete();
        DB::commit();

        return back();
    }

    public function showBuilding($id)
    {
        DB::beginTransaction();
            $building = Building::with('rooms')->find($id);
            $buildings = Building::all();
            $roomtypes = Room::getType();
        DB::commit();

        return view('admin.rooms.index', compact('building', 'buildings', 'roomtypes'));
    }
}
