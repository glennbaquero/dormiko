<?php

namespace App;

use App\RouteChecker;

class GlobalChecker
{
    protected $user;
    public $route;
    public $permission;

    public function __construct($user = null)
    {
        $this->user = $user ? $user : \Auth::user();

        /* Create the version checker */
        $this->route = new RouteChecker();
        $this->permission = new PermissionChecker($this->user);
    }    
}