<?php

namespace App\Http\Controllers;

use App\Admins\AboutUsContent;
use Illuminate\Http\Request;

class AboutUsContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.aboutus.index')
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admins\AboutUsContent  $aboutUsContent
     * @return \Illuminate\Http\Response
     */
    public function show(AboutUsContent $aboutUsContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admins\AboutUsContent  $aboutUsContent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admins\AboutUsContent  $aboutUsContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AboutUsContent $aboutUsContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admins\AboutUsContent  $aboutUsContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutUsContent $aboutUsContent)
    {
        //
    }
}
