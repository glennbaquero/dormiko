<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }


    public function billingrents()
    {
        return $this->hasMany(BillingRent::class);
    }

    public function billingutilities()
    {
        return $this->hasMany(BillingUtility::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function contract()
    {   
        return $this->hasMany(Contract::class);
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
        // return $this->hasMany(Reservation::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function reservationlists()
    {
        return $this->hasMany(UserReservationList::class);
    }

    public function renderFullname()
    {
        return ucwords($this->userDetail->firstname . ' ' . $this->userDetail->lastname);
    }
}
