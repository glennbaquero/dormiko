<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

use Carbon\Carbon;

class BillingRent extends Model
{

    use Searchable;
    
    protected $guarded = [];
    protected $dates = ['due_date', 'created_at'];
    
    public $asYouType = true;

    const UNPAID = 0;
    const PAID = 1;
    const OVERDUE = 2;

    const YEAR = 0;
    const MONTH = 1;
    const DAY = 2;

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id
        ];
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function contract()
    {
    	return $this->belongsTo(Contract::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public static function statusUpdate()
    {
        $now = Carbon::now();
        $billings = BillingRent::select(['id', 'due_date', 'status'])->where('due_date', '<', $now)->get();
        foreach($billings as $billing) {
            $billing->status = 2;
            $billing->save();
        }

    }

    public static function getStatus() {
        return [
            ['value' => static::UNPAID, 'label' => 'UNPAID', 'class' => 'bg-blue'],
            ['value' => static::PAID, 'label' => 'PAID', 'class' => 'bg-success'],
            ['value' => static::OVERDUE, 'label' => 'OVERDUE', 'class' => 'bg-red'],
        ];
    }

    public function renderView()
    {
    	return route('billing.edit', $this->id);
    }
}
