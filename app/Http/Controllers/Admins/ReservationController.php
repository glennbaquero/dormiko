<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;

use App\Notifications\ReservationApprovedNotification;
use App\Notifications\NewReservationNotification;
use App\Notifications\UserReservationNotification;
use App\Notifications\ReservationDenyNotification;

use App\Reservation;
use App\Contract;
use App\BillingRent;
use App\User;
use App\UserReservationList;
use App\Building;
use App\Invoice;
use App\Admin;
use App\UserDetail;
use Carbon\Carbon;
use DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.applicants.index', [
            'buildings' => Building::all()
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
    public function store(ReservationRequest $request)
    {
        DB::beginTransaction();
            $user = User::where('email', $request->email)->first();

            if(!is_null($user)) {
                return response()->json([
                    'message' => 'Email is already used!'
                ]);
            }

            // if(!is_null($user)) {
            //     $list = UserReservationList::create([
            //         'user_id' => $user->id,
            //         'firstname' => $request->firstname,
            //         'lastname' => $request->lastname,
            //         'gender' => $request->gender,
            //         'company' => $request->company,
            //         'contact' => $request->contact,
            //         'monthly_earning' => $request->monthly_earning,
            //         'workplace' => $request->workplace
            //     ]);

            //     if($request->moveout != 'undefined') {
            //         $list->user->reservation()->create($request->only(['overnight', 'movein', 'moveout', 'message', 'building_id', 'room_type']));
            //     } else {
            //         $list->user->reservation()->create($request->only(['overnight', 'movein', 'message', 'building_id', 'room_type']));
            //     }
            // } else {
                $user = User::create($request->only(['email']));
                $user->userDetail()->create($request->except(['email', 'overnight', 'movein', 'moveout', 'message', 'path', 'building_id', 'room_type']));
                
                if($request->moveout != 'undefined') {
                    $user->reservation()->create($request->only(['overnight', 'movein', 'moveout', 'message', 'building_id', 'room_type']));
                } else {
                    $user->reservation()->create($request->only(['overnight', 'movein', 'message', 'building_id', 'room_type']));
                }

                if($request->hasFile('path')) {
                    foreach ($request->file('path') as $doc) {
                        $path = $doc->store('user-documents', 'public');
                        $user->documents()->create(['path' => $path]);
                    }
                }
            // }

            $building = Building::find($request->building_id);
            $super_admins = Admin::where(['type' => 0])->get();
            // if(!is_null($find)) {
                $user->notify(new UserReservationNotification($building));  
            // } else {
            //     $user->notify(new UserReservationNotification($building));  
            // }
            
            if($super_admins) {
                foreach($super_admins as $admin) {
                    $admin->notify(new NewReservationNotification($building, $user));
                }    
            }
            
            if($building->admin) {
                $building->admin->notify(new NewReservationNotification($building, $user));
            }      

        DB::commit();

        

        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.applicants.edit', [
            'applicant' => Reservation::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = '';
        DB::beginTransaction();
        $tenant_id = UserDetail::where('tenant_id', $request->tenant_id)->whereNotNull('tenant_id')->first();
        $reserve = Reservation::find($id);
        // $reserve->moveout = $request->duration_to;

        if($tenant_id) {
            return response()->json([
                'message' => 'Tenant ID is already Exist'
            ]);
        }

        if(!$request->status) {
            $contract = Contract::create($request->except('tenant_id'));
           
            $lists = $contract->user->reservationlists;
            $token = "";
            if(empty($request->input('tenant_id'))) {
                $codeAlphabet = Carbon::now()->year;
                $codeAlphabet.= Carbon::now()->format('m');
                $codeAlphabet.= Carbon::now()->format('d');
                $tenant_id = str_pad($contract->id, 4, '0', STR_PAD_LEFT);
                $codeAlphabet.= '-'.$tenant_id;
                $contract->user->userDetail->tenant_id = $codeAlphabet;
            } else {
                $contract->user->userDetail->tenant_id = $request->tenant_id;
            }
            
            
            $contract->user->is_verified= 1;
            $contract->user->save();
            $contract->user->userDetail->save();

            $start = $contract->duration_from->month;
            $end = Carbon::parse($contract->duration_from)->addMonth();
            $contract->duration_to = $end->format('Y-m-d');
            $contract->save();
            $end = $end->month;
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
                // $contract->billing_rents()->create(['due_date'=>$due_date]);
            }
            $reservation = Reservation::find($id)->update(['status' => 1]);

            // creating token for updating password
            $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($contract->user);
            // send notification with updating password url
            $contract->user->notify(new ReservationApprovedNotification($token));

            $message = 'You have successfully approved the new tenant!';
        } else {
            $reservation = Reservation::find($id);
            $reservation->user->notify(new ReservationDenyNotification());
            $reservation->update(['status' => $request->status]);
        }

        $reserve->save();
        DB::commit();

        return response()->json([
            'message' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function deny($id)
    {
        DB::beginTransaction();
            $reservation = Reservation::find($id);
            $reservation->user->notify(new ReservationDenyNotification());
            $reservation->update(['status' => 3]);
        DB::commit();
        return back();
    }
}
