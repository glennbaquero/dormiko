<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;
use App\Traits\ActivityLogTrait;

use Carbon\Carbon;

class BillingUtility extends Model
{
    use Searchable, ActivityLogTrait;

    protected $guarded = [];
    protected $dates = ['created_at', 'due_date', 'duration_start', 'duration_end'];

    public $asYouType = true;

    const UNPAID = 0;
    const PAID = 1;
    const OVERDUE = 2;

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id,
        ];
    }

    public static function getStatus() {
        return [
            ['value' => static::UNPAID, 'label' => 'UNPAID', 'class' => 'bg-blue'],
            ['value' => static::PAID, 'label' => 'PAID', 'class' => 'bg-success'],
            ['value' => static::OVERDUE, 'label' => 'OVERDUE', 'class' => 'bg-red'],
        ];
    }

    public function contract()
    {
    	return $this->belongsTo(Contract::class);
    }

    public function utility()
    {
    	return $this->belongsTo(Utility::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }


    public static function statusUpdate()
    {
        $now = Carbon::now();
        $billings = BillingUtility::select(['id', 'due_date', 'status'])->where('due_date', '<', $now)->get();
        foreach($billings as $billing) {
            $billing->status = 2;
            $billing->save();
        }

    }

    public function renderName() {
        return ucwords($this->contract->user->userDetail->firstname. ' '. $this->contract->user->userDetail->lastname);
    }

    public function renderView()
    {
        return route('utility.edit', $this->id);
    }

}
