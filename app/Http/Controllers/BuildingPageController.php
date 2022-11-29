<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;

class BuildingPageController extends Controller
{
    public function showBuilding(Building $building)
    {    	
    	return view('pages.location.show',[
    		'building' => $building,
    	]);
    }
}
