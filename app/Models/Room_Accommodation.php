<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room_Accommodation extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'room_has_accommodations';
    protected $fillable = ['id_room', 'id_accommodation'];
    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function getAccommodationsByRoom($idRoomType)
    {
        return Room_Accommodation::leftJoin("accommodationtypes", "room_has_accommodations.id_accommodation", "=", "accommodationtypes.id")
                ->where("id_room", "=", $idRoomType)
                ->get();
    }

    public function RoomType()
    {
        return $this->hasMany('App\Models\RoomType', 'id_room', 'id' );
    }

    public function AccommodationType()
    {
        return $this->belongsToMany('App\AccommodationType', 'id_accommodation', 'id');
    }

}
