<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Sofa\Eloquence\Eloquence;

class inquiry extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id_inquiry';
    protected $table = 'inquiry';
    public $timestamps = true;

    public function get_customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id_customers');
    }

}
