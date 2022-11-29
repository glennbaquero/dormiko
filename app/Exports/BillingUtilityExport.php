<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\BillingUtility;

class BillingUtilityExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->formatColumns(
                            BillingUtility::all()
                    ));
    }

    public function headings() : array
    {
    	return [
    		'ID',
    		'TENANT ID',
    		'TENANT',
    		'TYPE',
    		'DURATION',
    		'DUE DATE',
    		'STATUS',
    		'AMOUNT',
    		'PENALTY',
    		'TOTAL PAYMENT',
    	];
    }

    private function formatColumns($datas, $billings = [])
    {
    	foreach ($datas as $data) {
			$formats = [
				'id' => $data->id,
				'tenant_id' => $data->contract->user->userDetail->tenant_id,
                'name' => $data->contract->user->userDetail->firstname.' '. $data->contract->user->userDetail->lastname,
                'type' => $data->utility->name,
                'duration' => $data->contract->duration_from->format('M d, Y').' - '.$data->contract->duration_to->format('M d, Y'),
                'due_date' => $data->due_date->format('M d, Y'),
                'status' => $data->invoice->status == 1 ? 'Paid' : ($data->due_date->format('Y-m-d') > date('Y-m-d') ? 'Unpaid' : 'Overdue'),
                'rental_fee' => $data->contract->room->price_range_from,
                'penalty' => $data->penalty,
                'total_payment' => $data->penalty + $data->invoice->amount,
			];   
			array_push($billings, $formats);
    	}

    	return $billings;
    }
}
