<?php

namespace App\Models;

/*use Illuminate\Database\Eloquent\Factories\HasFactory;*/
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    /*use HasFactory;*/
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employees';
    protected $fillable = ['id_person','empl_finicio', 'empl_ffin', 'empl_estado'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


    public function getEmployeeById($id)
    {
        //return Employee::find($id);
        $empl = Client::join("persons", "persons.id", "=", "id_person")
                    ->select("employees.*", "persons.id as idPerson", "pers_identif", "pers_tipoid", "pers_razonsocial", "pers_primernombre", "pers_segnombre",
                            "pers_primerapell", "pers_segapell", "pers_direccion", "pers_telefono", "pers_ciudad", "pers_dpto", "pers_email", "id_user")
                    ->where("employees.id", "=", $id)
                    ->get();

            
        //dd($empl);
        return $empl;

    }

    public function Person()
    {
        return $this->belongsTo('App\Models\Person', 'id_person', 'id');
    }

}
