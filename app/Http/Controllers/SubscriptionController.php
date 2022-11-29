<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subscription;

use DB;
class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
    	$request->validate([
    		'email' => 'required|email'
    	]);

    	// DB::beginTransaction();
    		Subscription::create($request->all());
    	// DB::commit();

    	return response()->json([
    		'message' => 'success'
    	]);
    }
}
