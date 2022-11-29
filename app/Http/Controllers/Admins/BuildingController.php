<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\BuildingRequests;

use App\Building;
use App\Amenity;
use Storage;
use Auth;
use DB;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::guard('admin')->user()->type === 1) {
            $buildings = \Auth::guard('admin')->user()->building;
        } else {
            $buildings = Building::with('images')->get();
        }

        return view('admin.buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuildingRequests $request)
    {
        DB::beginTransaction();

            $building = Building::create($request->except(['path', 'amenity_name', 'images', 'id', 'banner_image', 'dormitory_image', 'studio_image']));

            if($request->hasFile('dormitory_image')) {
                $unit_image = $request->file('dormitory_image')->store('unit-images', 'public');
                $building->dormitory_image = $unit_image;
            }

            if($request->hasFile('studio_image')) {
                $unit_image = $request->file('studio_image')->store('unit-images', 'public');
                $building->studio_image = $unit_image;
            }

            $building->save();

            // storing images in to public path
            if($request->hasFile('path')) {
                $path = $request->file('path')->store('building-images', 'public');
                $building->images()->create(['path' => $path]);
            }

            if($request->get('amenity_name')) {
                foreach($request->get('amenity_name') as $key => $amenity) {
                    if($request->hasFile('images')) {
                        $amenity_path = $request->file('images')[$key]->store('amenities-images', 'public');
                        $building->amenity()->create([
                            'name' => $amenity,
                            'image' => $amenity_path
                        ]);
                    }
                }
            }

            if($request->hasFile('banner_image')) {
                foreach($request->file('banner_image') as $key => $banner) {
                    $banner_path = $request->file('banner_image')[$key]->store('building-banner-images', 'public');
                    $building->banners()->create([
                        'image' => $banner_path
                    ]);
                }
            }
            

        DB::commit();

        return response()->json([
            'message' => 'You have successfully create a new building',
            'redirect' => $building->redirectTo(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        DB::beginTransaction();
            $building = Building::with('amenity', 'banners', 'images')->find($id);
        DB::commit();

        return view('admin.buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(BuildingRequests $request, $id)
    {
        DB::beginTransaction();
            $building = Building::find($id);

            // store new image
            if($request->hasFile('path')) {
                $path = $request->file('path')->store('building-images', 'public');
                $building->images()->create(['path' => $path]);
            }

            $building->update($request->except(['amenity_name','images', 'path', 'id', 'banner_id', 'banner_image', 'dormitory_image', 'studio_image']));

            if($request->hasFile('dormitory_image')) {
                Storage::delete('public/'. $building->dormitory_image);
                $unit_image = $request->file('dormitory_image')->store('unit-images', 'public');
                $building->dormitory_image = $unit_image;
            }

            if($request->hasFile('studio_image')) {
                Storage::delete('public/'. $building->studio_image);
                $unit_image = $request->file('studio_image')->store('unit-images', 'public');
                $building->studio_image = $unit_image;
            }

            $building->save();

            if($request->hasFile('banner_image')) {
                if($building->banners()->count()) {
                    foreach ($building->banners() as $value) {
                        Storage::delete('public/'. $building->banners()->value);
                    }
                }

                foreach($request->file('banner_image') as $key => $banner) {
                    $banner_path = $request->file('banner_image')[$key]->store('building-banner-images', 'public');
                    $building->banners()->updateOrCreate([
                        'id' => $request->get('banner_id')[$key]
                    ],[
                        'image' => $banner_path
                    ]);
                    // $building->banners()->updateOrCreate([
                    //     'id' => $request->get('banner_id')[$key]
                    // ],[
                    //     'image' => $banner_path
                    // ]);
                }
            }

             if($request->get('amenity_name')) {
                foreach($request->get('amenity_name') as $key => $amenity) {
                    if(!empty($request->file('images')[$key])) {
                        $amenity_path = $request->file('images')[$key]->store('amenities-images', 'public');
                        
                        $building->amenity()->updateOrCreate([
                            'id' => $request->get('id')[$key]
                        ], [
                            'name' => $amenity,
                            'image' => $amenity_path
                        ]);

                    } else {
                        $building->amenity()->updateOrCreate([
                            'id' => $request->get('id')[$key]
                        ], [
                            'name' => $amenity,
                        ]);
                    }
                }
            }

            // $building
        DB::commit();

        return response()->json([
            'message' => 'You have successfully update the '.$building->name,
            'redirect' => $building->renderBack(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
            $building = Building::find($id);
            $building->amenity()->delete();
            $building->delete();
        DB::commit();

        return back();
    }

    public function destroyAmenities($id)
    {
        DB::beginTransaction();
            $amenity = Amenity::find($id);
            $amenity->delete();
        DB::commit();
    }
}
