<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table    = 'rooms';
    protected $fillable = ['id_hotel','id_tipohab', 'id_acomodacion', 'cant'];
    protected $hidden   = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function getRoomById($id)
    {
        return Room::find($id);
    }

    public function getRoomsByIdHotel($idHotel)
    {
        return Room::select('rooms.*', 'roomtypes.nombre as TipoHab', 'accommodationtypes.nombre as Acomod')
                ->leftJoin("roomtypes", "rooms.id_tipohab", "=", "roomtypes.id")
                ->leftJoin("accommodationtypes", "rooms.id_acomodacion", "=", "accommodationtypes.id")
                ->where("id_hotel", "=", $idHotel)
                ->get();
    }

    public function Hotel()
    {
        return $this->belongsTo('App\Models\Hotel', 'id_hotel', 'id');
    }

    public function RoomType()
    {
        return $this->belongsTo('App\Models\RoomTypes', 'id_tipohab', 'id');
    }

    public function AccommodationType()
    {
        return $this->belongsTo('App\Models\AccommodationTypes', 'id_acomodacion', 'id');
    }

}
