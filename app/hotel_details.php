<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class hotel_details extends Authenticatable
{
    protected $table = 'hotel_details';
    protected $primaryKey = 'id_hotel_details';
}
