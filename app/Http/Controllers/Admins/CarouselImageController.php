<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\CarouselImage;

class CarouselImageController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarouselImage  $carouselImage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carousel = CarouselImage::find($id);
        Storage::delete('public/' . $carousel->image_path);
        $carousel->destroy($id);

        return response()->json([
            'message' => 'Succesfully removed the image in the slider!'
        ]);
    }
}
