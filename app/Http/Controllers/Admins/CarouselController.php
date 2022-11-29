<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Carousel;
use App\CarouselImage;
use App\CarouselTag;
use DB;

class CarouselController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = CarouselTag::select(CarouselTag::MINIMAL_COLUMN)->get();

        return view('admin.carousels.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.carousels.create');
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

        $carousel = Carousel::store($request);
        
        DB::commit();

        return response()->json([
            'message' => 'You have successfully create a new slider',
            'redirect' => $carousel->renderView(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.carousels.edit',[
            // 'carousel' => Carousel::withTrashed()->find($id),
            'carousel' => Carousel::find($id),
            'image_id' => CarouselImage::where('carousel_id', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $carousel = Carousel::withTrashed()->find($id);
        $carousel = Carousel::find($id);

        DB::beginTransaction();

        $carousel = Carousel::store($request, $carousel);
        
        DB::commit();
    
        return response()->json([
            'message' => 'You have successfully updated the slider'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carousel = Carousel::find($id);
        $carousel->delete();

        return response()->json([
            'message' => "You have successfully archived {$carousel->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // $carousel = Carousel::onlyTrashed()->find($id);
        $carousel = Carousel::find($id);
        $carousel->restore();

        return response()->json([
            'message' => "You have successfully restored {$carousel->renderName()}",
        ]);
    }


    /**
     * Remove the specified image.
     *
     * @param  \App\CarouselImage  $carouselimage
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $carouselimage = CarouselImage::find($id)->delete();

        return response()->json([
            'message' => "You have successfully removed the image from the slider",
        ]);
    }

}
