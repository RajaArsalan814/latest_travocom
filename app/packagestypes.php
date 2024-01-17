<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class packagestypes extends Authenticatable
{
    protected $table = 'packages_types';
    protected $primaryKey = 'id_packages_types';
}
