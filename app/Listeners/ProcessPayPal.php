<?php

namespace App\Listeners;

use PRAXXYSEcommerce\PayPal\Events\PayPalNotified;
use Illuminate\Support\Facades\Log;

use App\Notifications\InvoicePaid;
use App\Notifications\UserPaid;

use App\Invoice;
use Carbon\Carbon;

class ProcessPayPal
{

    protected $result;
    protected $invoice;

    /**
     * Handle the event.
     *
     * @param  \PRAXXYSEcommerce\PayPal\Events\PayPalNotified  $event
     * @return void
     */
    public function handle(PayPalNotified $event)
    {

        Log::info('Dispatching PayPalNotified...');

        # dd($event->result):
        # [
        #   "reference_code" => "(your invoice reference)",
        #   "transaction_code" => "Transaction code from PayPal",
        # ]
        $this->result = $event->result;

        # PROCESS YOUR ACTIONS HERE:
        
        $this->processInvoice();
        $this->notifyUser();
        $this->notifyAdmin();
    }


    /* * * * * * * * * * * * * * *
     * SAMPLE CODE FOR REFERENCE *
     * * * * * * * * * * * * * * */


    private function processInvoice() {

        \DB::beginTransaction();

        # will cause error if no code is there
        $this->invoice = Invoice::where('reference_code', $this->result['reference_code'])->first();
        $this->invoice->status = 1;
        $this->invoice->payment_method = 1;
        $this->invoice->payment_gateway_code = $this->result['transaction_code'];
        $this->invoice->payment_date = Carbon::now()->format('Y-m-d');

        
        $this->invoice->save();
        if($this->invoice->billing_rent) {
            $this->invoice->billing_rent->status = 1;
            $this->invoice->billing_rent->save();
        } else {
            $this->invoice->billing_utility->status = 1;
            $this->invoice->billing_utility->save();
        }
        

        \DB::commit();

    }

    private function notifyUser()
    {
        $this->invoice->user->notify(new UserPaid($this->invoice));
    }

    private function notifyAdmin()
    {
        $admins = Admin::all();

        foreach ($admins as $admin)
        {
            $admin->notify(new InvoicePaid($this->invoice));
        }
    }


}