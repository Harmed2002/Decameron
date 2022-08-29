<?php

namespace App\Models;

use App\Models\Hotel;
use Validator;


class HotelModel {

    /**
     * Get all Hotel
     * @param integer $paginate default value 10, quantity to be shown by pages, can be null
     * @param string $search value to be searched, can be null
     * @return Object Hotel
     */
    public static function listHotel($paginate = 10, $search = null) {

        $hotels = Hotel::query();
        $hotels->whereNull('deleted_at');
        $hotels->orderBy('name');
        if ($search) {
            $hotels->where(function ($sbQuery) use ($search) {
                $sbQuery->where('name', 'LIKE', "%$search%");
            });
        }

        return $paginate ? $hotels->paginate($paginate) : $hotels->get();
    }

    /**
     * get a Hotel by id
     * @param integer $Hotel id from database
     * @return Object Hotel FormHotel
     */
    public static function getHotel($id) {
        $hotel = Hotel::find($id);
        return $hotel;
    }

    /**
     * get validator for Hotel
     * @param array $data information from form
     * @return Object Validator
     */
    public static function getValidator($data) {
        //dd($data);
        $validator  = null;
        $niceNames = array(
            'nit.required'          => 'El nit es requerido',
            'nit.max'               => 'El nit debe tener maximo 12 caracteres',
            'nit.unique'            => 'El nit debe ser único, el ingresado ya existe',
            'nombre.required'       => 'El nombre es requerido',
            'nombre.max'            => 'El nombre debe tener maximo 50 caracteres',
            'direccion.required'    => 'La dirección es requerida',
            'direccion.max'         => 'La dirección debe tener maximo 200 caracteres',
            'numhab.required'       => 'El número de habitaciones es requerido',
        );

        //$valid = $data['id'] != '' ? '':',nit,'.$data['nit'] ;
        //dd($valid);
        $validator = Validator::make($data, [
            'nit'       => 'required|max:12',
            'nombre'    => 'required|max:50',
            'direccion' => 'required|max:200',
            'numhab'    => 'required',
        ], $niceNames);

        return $validator;
    }

}
