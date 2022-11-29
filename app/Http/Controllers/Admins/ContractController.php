<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContractExport;
use App\Notifications\ReservationApprovedNotification;

use App\Contract;
use App\Reservation;
use App\Building;
use App\Room;
use App\BillingRent;
use App\Invoice;
use App\User;
use App\UserDetail;

use PDF;
use Carbon\Carbon;
use DB;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Contract::all();
        return view('admin.tenants.index');
    }

    public function contractIndex()
    {
        $now = Carbon::now();
        $checker = Contract::where('created_at', '>=', $now)->get();
        if(count($checker)) {
            $latest = Contract::latest()->first()->created_at->format('Y');
            $old = Contract::where('created_at', '<=', $latest)->first();
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

        $filter = json_encode(Contract::getStatus());
        $buildings = json_encode(Building::all());
        $rooms = json_encode(Room::all());
        $years_json = json_encode($years);
        $months = json_encode($month);
        $selects = json_encode($selection);
        
        return view('admin.contracts.index', [
            'filter' => $filter,
            'buildings' => $buildings,
            'rooms' => $rooms,
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
        // $buildings = \Auth::guard('admin')->user()->type != 0 ? \Auth::guard('admin')->user()->building : Building::with('rooms')->get();
        if(\Auth::guard('admin')->user()->type != 0) {
            $buildings = \Auth::guard('admin')->user()->building;
            $rooms = $buildings->rooms;
        } else {
            $buildings = Building::with('rooms')->get();
            $rooms = '{}';
        }
        // $buildings = Building::with('rooms')->get();
        return view('admin.contracts.create', [
            'buildings' => $buildings,
            'rooms' => $rooms
        ]);
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'movein' => 'required',
            // 'moveout' => 'required',
            'building_id' => 'required',
            'room_type' => 'required',
            'room_id' => 'required',
        ]);

        DB::beginTransaction();
            $move_out = Carbon::parse($request->movein)->addMonth();

            $tenant_id = UserDetail::where('tenant_id', $request->tenant_id)->whereNotNull('tenant_id')->first();
            $user = User::create($request->only(['email']));
            $user->is_verified = 1;
            $user->userDetail()->create($request->except(['moveout', 'movein', 'email', 'overnight', 'room_type', 'building_id', 'room_id', 'tenant_id']));
            $contract = Contract::create([
                'user_id' => $user->id,
                'room_id' => $request->room_id,
                'duration_from' => $request->movein,
                // 'duration_to' => $request->moveout,
                'duration_to' => $move_out->format('Y-m-d'),
                'status' => 1
            ]);

            if($tenant_id) {
                return response()->json([
                    'type' => 'error',
                    'header' => 'Ooops',
                    'message' => 'Tenant ID is already Exist'
                ]);
            }

            if(empty($request->input('tenant_id'))) {
                $codeAlphabet = Carbon::now()->year;
                $codeAlphabet.= Carbon::now()->format('m');
                $codeAlphabet.= Carbon::now()->format('d');
                $tenant_id = str_pad($contract->id, 4, '0', STR_PAD_LEFT);
                $codeAlphabet.= '-'.$tenant_id;
                $user->userDetail->tenant_id = $codeAlphabet;
                $user->userDetail->save();
            } else {
                $user->userDetail->tenant_id = $request->tenant_id;
                $user->userDetail->save();
            }

            // $user->reservation()->create($request->only(['overnight', 'movein', 'moveout', 'building_id', 'room_type']));
            $user->reservation()->create([
                'overnight' => $request->overnight,
                'movein' => $request->movein,
                // 'moveout' => $request->moveout,
                'moveout' => $move_out->format('Y-m-d'),
                'building_id' => $request->building_id,
                'room_type' => $request->room_type,
                'status' => 1,
            ]);
            $user->is_verified = 1;
            $user->save();

            $start = $contract->duration_from->month;
            $end = $contract->duration_to->month;

            for($i = 1; $i <= ($end-$start); $i++) {
                $due_date = Carbon::parse($contract->duration_from)->addMonth($i);
                
                $rent = BillingRent::create([
                    'contract_id' => $contract->id,
                    'due_date' => $due_date
                ]);

                $invoice = Invoice::create([
                    'user_id' => $contract->user->id,
                    'billing_rent_id' => $rent->id,
                    'reference_code' => strtoupper('DRMK' . str_random(10)),
                    'amount' => $rent->contract->room->price_range_from
                ]);

                // $invoice->amount = $invoice->billing_rent->contract->room->price_range_from;
                // $invoice->save();
            }

            // creating token for updating password
            $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($contract->user);
            // send notification with updating password url
            $user->notify(new ReservationApprovedNotification($token));


        DB::commit();

        return response()->json([
            'type' => 'success',
            'header' => 'Success',
            'message' => 'You have successfully create a new tenant!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Contract::find($id);
        if(\Auth::guard('admin')->user()->type != 0) {
            $buildings = \Auth::guard('admin')->user()->building;
            $rooms = $buildings->rooms;
        } else {
            $buildings = Building::with('rooms')->get();
            $rooms = '{}';
        }

        return view('admin.contracts.show', [
            'item' => $item,
            'buildings' => $buildings,
            'rooms' => $rooms
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.contracts.edit', [
            'contract' => Contract::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contract = Contract::find($id);
        $message = '';

        DB::beginTransaction();
        if($request->all()) {
            $contract->user->userDetail->update($request->all());
            $message = 'Tenant info updated!';
        } else {
            $contract_start = Carbon::parse($contract->duration_from);
            $contract_end = Carbon::parse($contract->duration_to)->addMonth();
            // dd($start->diffInMonths($end),  );
            $contract->update(['duration_from' => $contract_start, 'duration_to' => $contract_end]);
            $start = $contract->duration_from->month;
            $end = $contract->duration_to->month;
            // for($i = 1; $i < ($end-$start); $i++) {
                $due_date = Carbon::parse($contract->duration_from)->addMonth();

                $rent = BillingRent::create([
                    'contract_id' => $contract->id,
                    'due_date' => $contract_end
                ]);

                $invoice = Invoice::create([
                    'user_id' => $contract->user->id,
                    'billing_rent_id' => $rent->id,
                    'reference_code' => strtoupper('DRMK' . str_random(10)),
                    'amount' => $contract->room->price_range_from
                ]);
            // }
            $contract->user->is_verified = 1;
            $contract->status = 1;
            $contract->save();
            $contract->user->save();
            $message = 'Tenant Renew!!';
        }
        DB::commit();

        return response()->json([
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        //
    }

    public function export(Request $request)
    {
        return Excel::download(new ContractExport($request), 'TenantContract.xlsx');
    }

    public function evict($id)
    {
        $contract = Contract::find($id);
        $contract->user->is_verified = 0;
        $contract->user->save();
        $contract->status = 3;
        $contract->save();
        return back();
    }

    public function printContract($id)
    {
        $contract = Contract::find($id);
        $today = Carbon::now();
        return view('admin.contracts.print', [
            'contract' => $contract,
            'today' => $today->format('m/d/Y')
        ]);
    }

    public function updateInfo(Request $request, $id) {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'movein' => 'required',
            // 'moveout' => 'required',
            'building_id' => 'required',
            'room_type' => 'required',
            'room_id' => 'required',
        ]);

        $contract = Contract::find($id);

        DB::beginTransaction();

            $move_out = Carbon::parse($request->movein)->addMonth();

            $contract->user->userDetail()->update($request->except(['moveout', 'movein', 'email', 'overnight', 'room_type', 'building_id', 'room_id', 'tenant_id']));
            $contract->update([
                'room_id' => $request->room_id,
                'duration_from' => $request->movein,
                // 'duration_to' => $request->moveout,
                'duration_to' => $move_out->format('Y-m-d'),
                'status' => 1
            ]);

            $contract->user->reservation->update([
                'overnight' => $request->overnight,
                'movein' => $request->movein,
                // 'moveout' => $request->moveout,
                'moveout' => $move_out->format('Y-m-d'),
                'building_id' => $request->building_id,
                'room_type' => $request->room_type,
                'status' => 1,
            ]);
            $contract->user->is_verified = 1;
            $contract->user->save();

            $start = $contract->duration_from->month;
            $end = $contract->duration_to->month;

            for($i = 1; $i <= ($end-$start); $i++) {
                $due_date = Carbon::parse($contract->duration_from)->addMonth($i);
                
                $rent = $contract->billing_rents()->update([
                    'due_date' => $due_date
                ]);

                $contract->user->invoices()->update([
                    'amount' => $contract->room->price_range_from
                ]);

            }

        DB::commit();

        return response()->json([
            'message' => 'You have successfully update the tenant!'
        ]);
    }
}
