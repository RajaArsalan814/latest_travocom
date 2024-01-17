<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hotel_rate extends Model
{
    protected $primaryKey = "id_hotel_rates";

    public static function  getRoomName($id)
    {
        $room_name=room_type::where('id_room_types',$id)->select('name')->first();
        return  $room_name->name;
    }
}
