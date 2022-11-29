<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BillingUtilityExport;
use App\Notifications\UserPaid;

use App\BillingUtility;
use App\Invoice;
use DB;

class BillingUtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'duration_start' => 'required',
            'contract_id' => 'required',
            'duration_end' => 'required',
            'due_date' => 'required',
            'utility_id' => 'required',
            'amount' => 'required|numeric',
        ]);
        DB::beginTransaction();
            $utility = BillingUtility::create($request->all());
            $invoice = Invoice::create([
                        'user_id' => $utility->contract->user->id,
                        'billing_utility_id' => $utility->id,
                        'reference_code' => strtoupper('DRMK' . str_random(10)),
                    ]);
        DB::commit();
        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BillingUtility  $billingUtility
     * @return \Illuminate\Http\Response
     */
    public function show(BillingUtility $billingUtility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillingUtility  $billingUtility
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.billings.utility', [
            'billing' => BillingUtility::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BillingUtility  $billingUtility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            $billing = BillingUtility::find($id);
            $billing->invoice->update([
                'status' => 1,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date
            ]);
            
            $billing->update(['status' => $request->status]);

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
     * @param  \App\BillingUtility  $billingUtility
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingUtility $billingUtility)
    {
        //
    }

    public function penalty(Request $request, $id)
    {
        DB::beginTransaction();
            $billing = BillingUtility::find($id);
            $billing->invoice->update(['status' => 1]);
            $billing->update(['penalty' => $request->get('penalty')]);
        DB::commit();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function export()
    {
        return Excel::download(new BillingUtilityExport(), 'BillingUtilityExportedData.xlsx');
    }
}
