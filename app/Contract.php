<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;
use App\Traits\ActivityLogTrait;

use Carbon\Carbon;

class Contract extends Model
{
    use Searchable, ActivityLogTrait;

    protected $guarded = [];
    protected $dates = ['deleted_at', 'duration_to', 'duration_from', 'created_at'];

    public $asYouType = true;

    const ACTIVE = 1;
    const EXPIRING = 0;
    const EVICTED = 3;

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
        ];
    }

    public function user()
    {
    	return $this->belongsTo(User::class)->with('userDetail');
    }

    public function room()
    {
    	return $this->belongsTo(Room::class);
    }

    public function billing_rents()
    {
        return $this->hasMany(BillingRent::class);
    }

    public function billing_utilities()
    {
        return $this->hasMany(BillingUtility::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function duedates()
    {
        return $this->hasMany(DueDate::class);
    }

    /**
     * @Helpers
     */
    public function renderConstants($array, $value, $column = null) 
    {

        /* Loop through the array */
        foreach ($array as $obj) {
            
            if($obj['value'] == $value) {

                /* Fetch columm if specified */
                if($column && isset($obj[$column]))
                    return $obj[$column];

                return $obj;
            }
        }
    }

    public static function getStatus() 
    {
        return [
            ['value' => static::ACTIVE, 'label' => 'Active', 'class' => 'btn-primary btn-flat btn-xs'],
            ['value' => static::EXPIRING, 'label' => 'Expiring', 'class' => 'btn-danger btn-flat btn-xs'],
            ['value' => static::EVICTED, 'label' => 'Moved Out', 'class' => 'btn-danger btn-flat btn-xs'],
        ];
    }

    public function renderStatusLabel() 
    {
        return $this->renderConstants(static::getStatus(), $this->status, 'label');
    }

    public function renderStatusClass() 
    {
        return $this->renderConstants(static::getStatus(), $this->status, 'class');
    }

    public function redirectToApplicantIndex()
    {
    	return redirect()->route('applicants');
    }

    public function renderView()
    {
        return route('contract.edit', $this->id);
    }

    public function evictRoute()
    {
        return route('evict.tenant', $this->id);
    }

    public function restoreTenant() {
        return route('contract.update', $this->id);
    }

    public function editContract() {
        return route('contract.show', $this->id);
    }

    public function renderName() {
        return ucwords($this->user->userDetail->firstname. ' '.$this->user->userDetail->lastname);
    }
}
