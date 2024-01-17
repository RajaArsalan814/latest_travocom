<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\quotation;

class quotation_approval extends Model
{
    protected $primaryKey = "id_quotation_approvals";

    public function get_quotation()
    {
        return $this->belongsTo(quotation::class, 'quotation_id', 'id_quotations');
    }
    public function get_user()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
