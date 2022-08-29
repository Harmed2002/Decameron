<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'countries';
    protected $fillable = ['nombre'];
    protected $hidden = ['id'];


    public function getStateById($id)
    {
        return State::find($id);
    }

    public function State()
    {
        return $this->hasMany('App\Models\State', 'id', 'id_country');
    }

    public function Hotel()
    {
        return $this->hasMany('App\Models\Hotel', 'id', 'id_country');
    }

}
