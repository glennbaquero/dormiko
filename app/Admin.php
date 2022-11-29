<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Password;
use Route;
use App\Helpers;
class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guarded = [];
	protected $guard_name = 'admin';

    const DEFAULT = 0;
    const BILLING = 1;

    public function building()
    {
        return $this->belongsTo(Building::class)->with('images');
    }

    /**
     * Boot All Model Events
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // foreach (static::getModelEvents() as $event) {
        //     static::$event(function($model) use ($event) {
        //         $name = Route::currentRouteName();

        //         switch ($name) {
        //             case 'admin.logout':
                    
        //                 break;
                    
        //             default:
        //                     $model->addActivity($event);
        //                 break;
        //         }
        //     });
        // }
    }

     /**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
	    $this->notify(new ResetPasswordNotification($token));
	}

    public function renderFullname() {
        return ucwords($this->firstname . ' ' . $this->lastname);
    } 

    public function renderName() {
        return ucwords($this->firstname . ' ' . $this->lastname);
    }
}
