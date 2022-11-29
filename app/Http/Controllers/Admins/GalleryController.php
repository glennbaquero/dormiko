<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use App\Gallery;
use App\GalleryImage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        
            $gallery = Gallery::create($request->except(['images']));
            if($request->hasFile('images')) {
                foreach($request->file('images') as $image) {
                    $path = $image->store('gallery-page', 'public');
                    $gallery->images()->create(['image' => $path]);
                }   
            }


        DB::commit();

        return response()->json([
            'message' => 'Added succesfully'
        ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::with('images')->find($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            $gallery = Gallery::find($id);
            $gallery->update($request->except(['images']));
            if($request->hasFile('images')) {
                // foreach($gallery->images as $img) {
                //     foreach($request->file('images') as $image) {
                //         $path = $image->store('gallery-page', 'public');
                //         $img->image = $path;
                //     }   
                //         $img->save();

                foreach($request->file('images') as $image) {
                    $path = $image->store('gallery-page', 'public');
                    $gallery->images()->create(['image' => $path]);
                }

            }
                

        DB::commit();

        return response()->json([
            'message' => 'Updated Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Gallery::find($id)->delete();

        return back();
    }

    /**
     * Remove the image in gallery.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        
        GalleryImage::find($id)->delete();

        return back();
    }

}
