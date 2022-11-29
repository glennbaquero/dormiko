<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Notifications\InvoicePaid;
use App\Notifications\UserPaid;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BillingRentExport;

use App\BillingRent;
use App\BillingUtility;
use App\Invoice;
use App\Contract;
use App\Utility;

use Carbon\Carbon;

use DB;

class BillingRentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $now = Carbon::now();
        $checker = BillingRent::where('created_at', '>=', $now)->get();
        // dd(count($checker));
        if(count($checker)) {
            $latest = BillingRent::latest()->first()->created_at->format('Y');
            $old = BillingRent::where('created_at', '<=', $latest)->first();

            if($old != null) {
                $old->created_at->format('Y');
            } else {
                $old = Carbon::now()->year;
            }

            $sub_year = $latest - $old;
            $range = range($old, $old + $sub_year);
            $years = $range;
        } else {
            $latest = Carbon::now()->year;
            $old = Carbon::now()->year;
            $sub_year = $latest - $old;
            $range = range($old, $old + $sub_year);
            $years = $range;
        }

        $selection = ['Year', 'Month'];

        for($m=1; $m<=12; ++$m){
            $month[] = date('F', mktime(0, 0, 0, $m, 1));
        }

        $filter = json_encode(BillingRent::getStatus());
        $filterUtility = json_encode(BillingUtility::getStatus());
        $type = json_encode(Utility::all());

        $years_json = json_encode($years);
        $months = json_encode($month);
        $selects = json_encode($selection);

        return view('admin.billings.index', [
            'contracts' => Contract::with('user')->get(),
            'utilities' => Utility::all(),
            'filter' => $filter,
            'filterUtility' => $filterUtility,
            'type' => $type,
            'years' => $years_json,
            'months' => $months,
            'selects' => $selects
        ]);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BillingRent  $billingRent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.billings.history', [
            'billing' => Invoice::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillingRent  $billingRent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.billings.edit', [
            'billing' => BillingRent::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BillingRent  $billingRent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            $billing = BillingRent::find($id);

            $billing->invoice->update([
                'payment_method' => 3,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'status' => $request->status,
            ]);


            $billing->status = $request->status;
            $billing->save();

            if($request->status == 1) {
                $billing->invoice->user->notify(new UserPaid($billing->invoice));
            }
        DB::commit();

        return response()->json([
            'message' => 'Invoice Saved!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillingRent  $billingRent
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingRent $billingRent)
    {
        //
    }

    public function penalty(Request $request, $id)
    {
        DB::beginTransaction();
            $billing = BillingRent::find($id)->update(['penalty' => $request->get('penalty')]);
        DB::commit();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function export()
    {
        return Excel::download(new BillingRentExport(), 'BillingRentExportedData.xlsx');
    }
}
