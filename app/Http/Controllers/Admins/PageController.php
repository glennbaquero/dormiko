<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use App\Page;
use App\PageItem;
use App\Building;
use App\Reservation;
use App\Contract;
use App\BillingRent;
use App\BillingUtility;
use App\ActivityLog;

class PageController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
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

        $page = Page::store($request);

        DB::commit();

        return response()->json([
            'message' => 'You have successfully create a new Page',
            'redirect' => $page->renderView(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $page = Page::withTrashed()->find($id);
        $page = Page::find($id);
        $types = json_encode(PageItem::getTypes());

        return view('admin.pages.edit', [
            'page' => $page,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $page = Page::withTrashed()->find($id);
        $page = Page::find($id);

        DB::beginTransaction();

        $page = Page::store($request, $page);

        DB::commit();

        return response()->json([
            'message' => "You have successfully updated {$page->renderName()}",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $page = Page::withTrashed()->find($id);
        $page = Page::find($id);
        $page->delete();

        return response()->json([
            'message' => "You have successfully archived {$page->renderName()}",
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // $page = Page::onlyTrashed()->find($id);
        $page = Page::find($id);
        $page->restore();

        return response()->json([
            'message' => "You have successfully restored {$page->renderName()}",
        ]);
    }

    public function overview()
    {
        $now = Carbon::now();
        $buildings = Building::count();
        $reservations = Reservation::count();
        $active_contracts = Contract::where('duration_to', '>', Carbon::now())
                                        ->where('status', 1)->count();
        $expiring_contracts = Contract::where('duration_to', '>', Carbon::now()->addDays(2))
                                        ->where('status', 1)->count();
       
        $tenants = Contract::count();
        $tenants_good_standing = Contract::count();
        $overdue = BillingRent::where('due_date', '<=', Carbon::now())->count() + BillingUtility::where('due_date', '<=', Carbon::now())->count();
        $billing = BillingRent::where('status', 2)->get()->count() + BillingUtility::where('status', 2)->get()->count() ;
        $good_standing = BillingRent::where('status', 1)->get()->count() + BillingUtility::where('status', 1)->get()->count();

        $activities = ActivityLog::orderBy('id', 'desc')->get();

        return view('admin.overviews.index', compact('buildings', 'reservations', 'active_contracts', 'expiring_contracts', 'tenants', 'billing', 'overdue', 'good_standing', 'activities'));
    }
}
