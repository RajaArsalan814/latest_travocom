<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class bank_accounts extends Authenticatable
{
    protected $table = 'bank_accounts';
    protected $primaryKey = 'id_bank_accounts';
}
