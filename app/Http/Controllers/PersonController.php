<?php

namespace App\Http\Controllers;

use App\Models\Admin\PermissionModel;
use App\Models\Person;
use App\Models\PersonModel;
use App\Models\Society;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PersonController extends Controller {
    /**
     * Creamos el constructor para inyectar la dependencia de la clase Person
     * para utilizarlo en los métodos de la clase ClientController
     */
    protected $persons;

    public function __construct(Person $persons) {
        $this->persons = $persons;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        
        $society = Society::find($request->id);
        $person = $society->Person;
        return response()->json(['data'=>['person' => $person,'society'=>$society]]);
    }
}
