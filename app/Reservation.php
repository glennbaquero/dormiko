<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Notification;

class Reservation extends Model
{
    protected $guarded = [];
    protected $dates = ['deleted_at', 'movein', 'moveout'];

    const APARTMENT = 0;
    const DORM = 1;
    const STUDIO = 2;

    public function user()
    {
    	return $this->belongsTo(User::class)->with('documents');
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }


    public static function roomType() {
        return [
            ['value' => static::APARTMENT, 'label' => 'Apartment', 'class' => 'bg-red'],
            ['value' => static::DORM, 'label' => 'Dorm', 'class' => 'bg-blue'],
            ['value' => static::STUDIO, 'label' => 'Studio', 'class' => 'bg-green'],
        ];
    }

    public function renderView() {
    	return route('applicant.edit', $this->id);
    }

    public function reservationDeny() {
    	return route('applicant.deny', $this->id);
    }
}
