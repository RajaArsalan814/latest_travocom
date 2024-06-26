<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $primaryKey = "id_payments";

    function get_quotation()
    {
        return $this->belongsTo(quotation::class, 'quotation_id', 'id_quotations');
    }

    function get_quotation_details()
    {
        return $this->belongsTo(quotations_detail::class, 'quotation_detail_id', 'uniq_id');
    }
}
