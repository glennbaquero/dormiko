<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class UserDetail extends Model
{
	use Searchable;

	protected $guarded = [];
	protected $dates = ['birthdate'];

	public $asYouType = true;

	public function toSearchableArray() {
	    return [
            'id' => $this->id,
	        'firstname' => $this->firstname,
	        'tenant_id' => $this->tenant_id,
	        'lastname' => $this->lastname,
	    ];
	}

   	public function user()
   	{
   		return $this->belongsTo(User::class);
   	}

   	
}
