<?php

namespace App\Http\Controllers;

use App\Building;
use App\Carousel;
use App\Page;
use App\PageItem;
use App\Room;
use App\Amenity;
use App\AboutUsContent;
use Illuminate\Http\Request;

class PageController extends Controller
{

	/**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->first();

        if(!$page) {
            switch ($slug) {
                case 'admin':
                        return redirect()->route('admin.login.show');
                    break;

                case 'tenant':
                        return redirect()->route('login');
                    break;

                default:
                        abort(404);
                    break;
            }
        }

        $data = $page->getData($request);
        return view($data['view'], $data);
    }

    public function home()
    {
    	$buildings = Building::with('images')->get();
    	$carousels = Carousel::with('images')->whereHas('tags', function($query){
            $query->where('name', 'home');
        })->get();
        
        $page = Page::where('slug', 'home')->first();
        return view('pages.home', 
            $page->getData()
        );
    	// return view('pages.home', compact('buildings', 'carousels'));
    }

    public function about() 
    {
       $contents = AboutUsContent::all();
       $item = PageItem::where('slug', 'about_us_banner_image')->first();
       return view('pages.about', compact('contents', 'item'));
    }

    public function location()
    {
        $buildings = Building::with('images', 'banners')->get();
        return view('pages.location.index', compact('buildings'));
    }

    public function showLocation(Building $building)
    {
        $apartment = $building->rooms->where('room_type', 0)->first();
        $max_apartment = $building->rooms->where('room_type', 0)->max('price_range_from');
        $min_apartment = $building->rooms->where('room_type', 0)->min('price_range_from');
        $dorm = $building->rooms->where('room_type', 1)->first();
        $max_dorm = $building->rooms->where('room_type', 1)->max('price_range_from');
        $min_dorm = $building->rooms->where('room_type', 1)->min('price_range_from');
        $studio = $building->rooms->where('room_type', 2)->first();
        $max_studio = $building->rooms->where('room_type', 2)->max('price_range_from');
        $min_studio = $building->rooms->where('room_type', 2)->min('price_range_from');

        $galleries = Page::where('slug', 'home')->first()->getData()['item'];
        // $buildings = Amenity::where('building_id', $building->id)->get();
        // dd($buildings, $building->id);

        return view('pages.location.show', compact('building','apartment', 'studio', 'dorm', 'galleries', 'min_dorm', 'max_dorm', 'max_studio', 'min_studio', 'max_apartment', 'min_apartment'));
    }

    public function reservation(Building $building, Room $room) 
    {
        $location = Page::where('slug', 'location')->first()->getData()['item'];
        return view('pages.location.reservation', compact('location','building','room'));
    }
}
