<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cities';
    protected $fillable = ['id_state','nombre'];
    protected $hidden = ['id'];


    public function getCities($idState)
    {
        $cities = City::where('id_state', $idState)->get();
         return $cities;
    }

    public function getCityById($id)
    {
        return City::find($id);
    }

    public function State()
    {
        return $this->belongsTo('App\Models\State', 'id_state', 'id');
    }

}
