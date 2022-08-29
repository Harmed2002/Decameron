<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table    = 'hotels';
    protected $fillable = ['nit', 'nombre', 'direccion', 'numhab', 'id_country', 'id_state', 'id_city'];
    protected $hidden   = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function getHotelById($id)
    {
        $hotel = Hotel::find($id);
        return $hotel;
    }

    public function Country()
    {
        return $this->belongsTo('App\Models\Country', 'id_country', 'id');
    }

    public function State()
    {
        return $this->belongsTo('App\Models\State', 'id_state', 'id');
    }

    public function City()
    {
        return $this->belongsTo('App\Models\City', 'id_city', 'id');
    }

    public function Room()
    {
        return $this->hasMany('App\Models\Room', 'id', 'id_hotel');
    }

}
