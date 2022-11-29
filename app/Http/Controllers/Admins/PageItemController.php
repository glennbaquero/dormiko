<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PageItemPost;

use DB;

use App\PageItem;
use App\Page;

class PageItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::select(Page::MINIMAL_COLUMN)->whereHas('page_items')->orderBy('slug', 'asc')->get();
        $types = json_encode(PageItem::getTypes());

        return view('admin.page-items.index', [
            'pages' => $pages,
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page-items.create');
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

        $pageItem = PageItem::store($request);

        DB::commit();

        return response()->json([
            'message' => 'You have successfully create a new PageItem',
            'redirect' => $pageItem->renderView(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PageItem  $pageItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PageItem  $pageItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $pageItem = PageItem::withTrashed()->find($id);
        $pageItem = PageItem::find($id);

        return view('admin.page-items.edit', [
            'pageItem' => $pageItem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PageItem  $pageItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $pageItem = PageItem::withTrashed()->find($id);
        $pageItem = PageItem::find($id);

        DB::beginTransaction();

        $pageItem = PageItem::store($request, $pageItem);

        DB::commit();

        return response()->json([
            'message' => "You have successfully updated {$pageItem->renderName()}",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PageItem  $pageItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $pageItem = PageItem::withTrashed()->find($id);
        $pageItem = PageItem::find($id);
        $pageItem->delete();

        return response()->json([
            'message' => "You have successfully archived {$pageItem->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\PageItem  $pageItem
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // $pageItem = PageItem::onlyTrashed()->find($id);
        $pageItem = PageItem::find($id);
        $pageItem->restore();

        return response()->json([
            'message' => "You have successfully restored {$pageItem->renderName()}",
        ]);
    }
}
