<?php

namespace App\Models;

use App\Models\Supplier;
use Validator;
// app includes


class SupplierModel {

    /**
     * Get all Supplier
     * @param integer $paginate default value 10, quantity to be shown by pages, can be null
     * @param string $search value to be searched, can be null
     * @return Object Supplier
     */
    public static function listSuppliers($paginate = 10, $search = null) {

        $supplier = Supplier::query();

        return  $supplier->orderBy('id','DESC')->paginate(7);
    }

    /**
     * get a Supplier by id
     * @param integer $supplier id from database
     * @return Object Supplier 
     */
    public static function getSupplier($idSupplier) {
        // Estas funcion se puede usar si necesitan un proveedor, se busca por id
        $supplier = Supplier::find($idSupplier);

        return $supplier;
    }

    /**
     * get validator for Supplier
     * @param array $data information from form
     * @return Object Validator
     */
    public static function getValidator($data) {
        $validator = Validator::make($data, [
            'prov_identif'      => ['required', 'max:12'],
            'prov_codactividad' => ['required', 'max:3'],            

        ]);
    
        // 'reputationNotes',
        // Con esto se cambia el mensaje, que muestra la validacion
        $niceNames = array(
            'prov_identif'      => 'Identificación',
            'prov_codactividad' => 'Cód. de Actividad',
        );

        $validator->setAttributeNames($niceNames);

        return $validator;
    }

}
