<?php

namespace App\Traits;

use Log;
use Auth;

use App\ActivityLog;

trait ActivityLogTrait {

    abstract public function renderName();
     
    /**
     * Boot All Model Events
     * @return void
     */
	public static function boot()
    {
        parent::boot();

        foreach (static::getModelEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->addActivity($event);
            });
        }
    }

    /**
     * List of Model Events
     * @return array
     */
    public static function getModelEvents() {
        return [
            'created',
            'updated',
            'deleted',
        ];
    }

    /**
     * Create Activity Log
     * @param string $event Name of Model Event fired
     */
    public function addActivity($event) {
    	$auth = Auth::guard('admin');
        $log = null;

    	if ($auth->check()) {

    		$user = $auth->user();
    		$classname = get_class($this);
    		$data = [
    			'auth_id' => $user->id,
    			'auth_class' => get_class($user),
    			'model_id' => $this->id,
    			'model_class' => $classname,
    			'event' => $event,
    			'message' => $user->renderFullname() . ' <b>' . $event . '</b> ' . class_basename($classname) . ' ' . $this->renderName(),
    		];

            $log = ActivityLog::create($data);
    	}

        return $log;
    }
}