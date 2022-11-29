<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\UserDetail;
use App\User;
use App\Invoice;

use DB;
use PDF;
use Carbon\Carbon;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tenant.profile.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            $detail = UserDetail::find($id);
            $detail->update($request->all());
        DB::commit();

        return response()->json([
            'response' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatePassword(Request $request, $id)
    {

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $user = User::find($id);
        if(Hash::check($request->input('old_password'), $user->password)){
            $user->update(['password' => Hash::make($request->input('password'))]);
            $response = 1;
        } else {
            $response = 404;
        }

        return response()->json([
            'response' => $response,
        ]);
    }

    public function payment()
    {
        return view('tenant.payment.index');
    }

    public function paymentSuccess()
    {
        return view('tenant.overview.index');
    }

    public function checkout($id)
    {
        $invoice = Invoice::find($id);
        return view('tenant.checkout.index',[
            'invoice' => $invoice,
        ]);
    }

    public function process(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->update([
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'invoice' => ['id' => $invoice->id, 'reference' => $invoice->reference_code, 'currency' => 'PHP']
        ]);
    }

    public function success(Request $request)
    {
        return response()->json([
            'request' => $request->all()
        ]);
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::find($id);
        $today = Carbon::now();
        return view('tenant.invoice.index', [
            'invoice' => $invoice,
            'today' => $today->format('m/d/Y')
        ]);
    }

    public function generateInvoice($id)
    {
        $invoice = Invoice::find($id);
        $pdf = PDF::loadView('tenant.invoice.index', compact('invoice'));
        return $pdf->download('Invoice.pdf');
    }
}
