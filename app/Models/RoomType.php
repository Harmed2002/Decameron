<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'roomtypes';
    protected $fillable = ['nombre'];
    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function getRoomTypeById($id)
    {
        return RoomType::find($id);
    }

    public function Room()
    {
        return $this->hasMany('App\Models\State', 'id', 'id_tipohab' );
    }

    public function Room_Accommodation()
    {
        return $this->belongsToMany('App\Room_Accommodation', 'id', 'id_room');
    }

}
