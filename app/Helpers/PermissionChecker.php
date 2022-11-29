<?php

namespace App;

class PermissionChecker
{
	protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

	public function can($permissions) {
		return $this->user->hasAnyPermission($permissions);
	}
}