<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ActivityLogTrait;

use App\Room;

class Room extends Model
{
    use ActivityLogTrait;
    
    const APARTMENT = 0;
    const DORM = 1;
    const STUDIO = 2;

    protected $guarded = [];

    public function contract()
    {
    	return $this->hasOne(Contract::class);
    }

    public function building()
    {
    	return $this->belongsTo(Building::class);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }

    public function renderImage()
    {
    	return '/storage/' . $this->image;
    }

    public function renderType()
    {
        $type = null;

        if ($this->room_type == Room::APARTMENT)
        {
            $type = 'Apartment';
        }
        elseif($this->room_type == Room::DORM)
        {
            $type = 'Dormitory';
        }
        elseif($this->room_type == Room::STUDIO)
        {
            $type = 'Studio';
        }

        return $type;
    }

    public static function getType() 
    {
        return [
            ['value' => static::APARTMENT, 'label' => 'Apartment', 'class' => 'btn-danger btn-flat btn-xs'],
            ['value' => static::DORM, 'label' => 'Dorm', 'class' => 'btn-primary btn-flat btn-xs'],
            ['value' => static::STUDIO, 'label' => 'Studio', 'class' => 'btn-primary btn-flat btn-xs'],
        ];
    }

    public function renderName() {
        return $this->name;
    }
}
