<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class followup extends Model
{
    protected  $primaryKey = 'id_followups';

    // public function get_followup_remarks()
    // {
    //     return $this->hasMany(followup_remark::class,'id_followups' ,'followup_id');
    // }
}
