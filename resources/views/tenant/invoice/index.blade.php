@extends('admin-master')
@section('content')
<div class="content-wrapper">
   <section class="invoice">
      <div class="row">
         <div class="col-xs-12">
               <small class="pull-right">Date {{ Carbon\Carbon::now()->format('m/d/Y') }}</small>
            <h2 class="page-header">
               <div style="width: 15%">
                  @include('includes.svg_logo')
               </div>
            </h2>
         </div>
      </div>
      <div class="row invoice-info">
         <div class="col-sm-3 invoice-col">
            <address>
               <strong>{{ $invoice->user->userDetail->firstname. ' ' .$invoice->user->userDetail->lastname }}</strong><br>
               {{ $invoice->user->userDetail->address }}<br>
               Email: {{ $invoice->user->email }}
            </address>
         </div>
      <div class="col-sm-4 invoice-col">
         <address>
            <b>Payment Date</b> {{ $invoice->updated_at->format('M d, Y') }}<br>
         </address>
      </div>
      <div class="col-sm-4 invoice-col">
         
      </div>
   </div>

   <div class="row">
      <div class="col-xs-6">
         <p class="lead">Details</p>
         <div class="table-responsive">
            <table class="table"> 
               <tr>
                  <th>Building</th>
                  <td>{{ $invoice->billing_rent ? $invoice->billing_rent->contract->room->building->name : $invoice->billing_utility->contract->room->building->name }}</td>
               </tr>
               <tr>
                  <th>Room</th>
                  <td>{{  $invoice->billing_rent ? $invoice->billing_rent->contract->room->unit_name : $invoice->billing_utility->contract->room->unit_name }}</td>
               </tr>  
               <tr>
                  <th>Type</th>
                  <td>{{ $invoice->billing_rent ? 'Rent' : $invoice->billing_utility->utility->name. ' (Utility)' }}</td>
               </tr>
               <tr>
                  <th>Duration</th>
                  <td>{{ $invoice->billing_rent ? $invoice->billing_rent->contract->duration_from. ' - '. $invoice->billing_rent->contract->duration_to : $invoice->billing_utility->duration_start. ' - '. $invoice->billing_utility->duration_end }}</td>
               </tr>
               <tr>
                  <th>Due Date</th>
                  <td>{{ $invoice->billing_rent ? $invoice->billing_rent->due_date : $invoice->billing_utility->due_date }}</td>
               </tr>
               <tr>
                  <th>Payment Method</th>
                  <td>{{ $invoice->payment_method === 0 ? 'iPay88' : ($invoice->payment_method === 1 ? 'Paypal' : ($invoice->payment_method === 2 ? 'Bank Deposit' : ($invoice->payment_method === 3 ? 'Cash' : ''))) }}</td>
               </tr>
               <tr>
                  <th>Reference Code</th>
                  <td>{{ $invoice->reference_code }}</td>
               </tr>
            </table>
         </div>
      </div>
      <div class="col-xs-6">
         <p class="lead">Amount Due {{ $invoice->updated_at->format('m/d/Y') }}</p>
         <div class="table-responsive">
            <table class="table">
               
               <tr>
                  <th>Total:</th>
                  <td>₱{{ $invoice->amount }}</td>
               </tr>
            </table>
         </div>
      </div>
   </div>
   <div class="row no-print">
        <div class="col-xs-12">
          <button id="printBtn" class="btn btn-primary pull-right" style="margin-right: 5px;" onclick="printInvoice()">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>

   </section>
</div>
@endsection

@section('js')
<script type="text/javascript">
   function printInvoice() {
      window.print();
   }
</script>
@endsection