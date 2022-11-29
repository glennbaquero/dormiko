<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

use App\Admin;
use Auth;

class ActivityLog extends Model
{
	use Searchable;

    protected $fillable = [
    	'auth_id', 'auth_class',
    	'model_id', 'model_class',
    	'event',
    	'message',
    ];

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'message' => $this->message,
            'created_at' => $this->renderCreatedAt(),
        ];
    }

    /**
     * @Getters
     */
    public static function getAuthModels($logs = null) {

        if (!$logs) {
            $logs = ActivityLog::select(['auth_id']);
        }

        $ids = $logs->pluck('auth_id')->toArray();
        $admins = Admin::whereIn('id', $ids)->get();
        $items = [];

        foreach ($admins as $admin) {
            $items[] = [
                'id' => $admin->id,
                'name' => $admin->renderFullname(),
            ];
        }

        return $items;
    }

    public function getAuthModel() {
        $route = null;
        $model = $this->auth_class;

        if (method_exists($model, 'withTrashed')) {
            $item = $model::withTrashed()->find($this->auth_id);
        } else {
            $item = $model::find($this->auth_id);
        }

        return $item;
    }

    public static function getModelEvents($logs = null) {
        if (!$logs) {
            $logs = ActivityLog::select('event');
        }

        $events = $logs->pluck('event')->unique()->toArray();
        $items = [];

        foreach ($events as $event) {
            $items[] = [
                'label' => ucwords($event),
                'value' => $event,
            ];
        }

        return $items;
    }

    public static function getModels($logs = null) {
        if (!$logs) {
            $logs = ActivityLog::select(['model_class']);
        }

        $classes = $logs->pluck('model_class')->unique()->toArray();
        $items = [];

        foreach ($classes as $class) {
            if ($class) {
                $items[] = [
                    'label' => class_basename($class),
                    'value' => $class,
                ];
            }
        }

        return $items;
    }

    public function getModel() {
        $model = $this->model_class;
        
        if (method_exists($model, 'withTrashed')) {
            $item = $model::withTrashed()->find($this->auth_id);
        } else {
            $item = $model::find($this->auth_id);
        }

        return $item;
    }

    /**
     * @Methods
     */
    public static function addActivity($event, $message, $instance = null) {
        $auth = Auth::guard('admin');
        $log = null;
        $id = null;
        $classname = null;

        if ($auth->check()) {

            $user = $auth->user();

            if ($instance) {
                $id = $instance->id;
                $classname = get_class($instance);
            }

            $data = [
                'auth_id' => $user->id,
                'auth_class' => get_class($user),
                'model_id' => $id,
                'model_class' => $classname,
                'event' => $event,
                'message' => '#' . $user->id . ' ' . $user->renderFullname() . ' ' . $message,
            ];

            $log = ActivityLog::create($data);
        }

        return $log;
    }

    /**
     * @Renders
     */

    public function renderMessage() {
        return $this->message;
    }

    public function renderEvent() {
        return ucwords($this->event);
    }

    public function renderModel() {
        $model = 'System';

        if ($this->model_class) {
            $model = class_basename($this->model_class);
        }

        return $model;
    }

    public function renderCreatedAt() {
        return $this->created_at->format('M d, Y (H:i:s)');
    }

    public function renderView() {
        $route = null;
        $model = $this->model_class;

        if ($model) {

            $item = $model::withTrashed()->find($this->model_id);

            if (method_exists($item, 'renderView')) {
                $route = $item->renderView();
            }

        }


        return $route;
    }

    public function renderViewUser() {
        $item = $this->getAuthModel();

        if (method_exists($item, 'renderView')) {
            $route = $item->renderView();
        }

        return $route;
    }
}
