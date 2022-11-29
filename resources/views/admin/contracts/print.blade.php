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
               <p>ID : <strong>{{ $contract->user->userDetail->tenant_id }}</strong></p>
               Tenant : <strong>{{ $contract->user->userDetail->firstname. ' ' .$contract->user->userDetail->lastname }}</strong><br>
               {{ $contract->user->userDetail->address }}<br>
               <p>Email: {{ $contract->user->email }}</p>
               <p>Contact #: {{ $contract->user->userDetail->contact ? $contract->user->userDetail->contact : '+63' }}</p>
               <p>Address : {{ $contract->user->userDetail->address ? $contract->user->userDetail->address : '' }}</p>
         </div>
         <div class="col-sm-3 invoice-col">
               <p>Company: {{ $contract->user->userDetail->company }}</p>
               <p>Company Address #: {{ $contract->user->userDetail->workplace }}</p>
         </div>
      {{-- <div class="col-sm-4 invoice-col">
         <address>
            <b>Payment Date</b> {{ $invoice->updated_at->format('M d, Y') }}<br>
         </address>
      </div> --}}
      <div class="col-sm-4 invoice-col">
         
      </div>
   </div>

   <div class="row">
      <div class="col-xs-12">
         <p class="lead">Rent Details</p>
         <div class="table-responsive">
            <table class="table">
               <tr>
                  <th>Building</th>
                  <th>Room</th>
                  <th>Type</th>
                  <th>Duration</th>
                  <th>Due Date</th>
               </tr>
               @foreach($contract->billing_rents as $rent) 
               <tr>
                  <td>{{ $contract->room->building->name }}</td>
                  <td>{{ $contract->room->unit_name }}</td>
                  <td>Rent</td>
                  <td>{{ $rent->contract->duration_from->format('M, d Y'). ' - '. $rent->contract->duration_to->format('M, d Y') }}</td>
                  <td>{{ $rent->invoice->billing_rent->due_date->format('M, d Y') }}</td>
               </tr>
               @endforeach
            </table>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12">
         <p class="lead">Utility Details</p>
         <div class="table-responsive">
            <table class="table">
               <tr>
                  <th>Building</th>
                  <th>Room</th>
                  <th>Type</th>
                  <th>Duration</th>
                  <th>Due Date</th>
               </tr>
               @foreach($contract->billing_utilities as $utility) 
               <tr>
                  <td>{{ $contract->room->building->name }}</td>
                  <td>{{ $contract->room->unit_name }}</td>
                  <td>{{ $utility->invoice->billing_utility->utility->name }}</td>
                  <td>{{ $utility->contract->duration_from->format('M, d Y'). ' - '. $utility->contract->duration_to->format('M, d Y') }}</td>
                  <td>{{ $utility->invoice->billing_utility->due_date->format('M, d Y') }}</td>
               </tr>
               @endforeach
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