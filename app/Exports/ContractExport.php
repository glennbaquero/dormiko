<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;

use App\Contract;

class ContractExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	use Exportable;

	public function __construct($request)
	{
		$this->request = $request;
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return collect($this->formatColumns(
        	$this->request
        ));
    }

    public function headings() : array
    {
    	return [
    		'TENANT ID',
    		'TENANT',
    		'TENANT MOVE IN',
    		'TENANT MOVE OUT',
    		'BUILDING',
            'UNIT NO',
    		'STATUS'
    	];
    }

    private function formatColumns($datas, $contracts = [])
    {
    	foreach ($datas->items as $data) {
			$formats = [
				'tenant_id' => $data['tenant_id'],
				'tenant' => $data['name'],
				'contract_start' => $data['duration_from'],
				'contract_end' => $data['duration_to'],
				'building' => $data['building'],
                'unit' => $data['unit'],
				'status' => $data['status'] == 1 ? 'Active' : ($data['status'] == 0 ? 'Move out' : 'Expiring'),
			];   
			array_push($contracts, $formats);
    	}

    	return $contracts;
    }
}
