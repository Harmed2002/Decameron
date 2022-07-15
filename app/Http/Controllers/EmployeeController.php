<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\State;
use App\Models\City;
use App\Models\Person;
use App\Models\PersonModel;
use App\Models\EmployeeModel;
/*use Auth;*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EmployeeController extends Controller {
    /**
     * Creamos el constructor para inyectar la dependencia de la clase City
     * para utilizarlo en los métodos de la clase EmployeeController
     */

     protected $cities;

     public function __construct(City $cities) {

        $this->cities = $cities;
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $employees = Employee::orderBy('id', 'ASC')->get();
        $states = State::all();

        return view('employees.index', ['employees' => $employees, 'states' => $states]);
    }

    public function Cities($state_id) {
        //return City::where('ciud_coddpto', '=', $state_id)->get();

        $cities = $this->cities->getCities($state_id);
        return $cities;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $employee = Employee::find($request->id);
        //dd($employee);
        $person = null;

        if (isset($request->show) && $request->show == 'true') {
            return view('employees.show', compact('employee'));

        } else {
            $states = State::all();
            $cities = City::all();
            if ($employee) {
                $person =  $employee->Person;
            }

            return view('employees.form', compact('employee', 'states', 'person', 'cities'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Creo los datos de Persona
        $person = [];
        $person['id']                   = '';
        $person['pers_identif']         = $request->idEmployee;
        $person['pers_tipoid']          = $request->TipoId;
        $person['pers_razonsocial']     = strtoupper($request->pers_razonsocial);
        $person['pers_primernombre']    = strtoupper($request->Nom1);
        $person['pers_segnombre']       = strtoupper($request->Nom2);
        $person['pers_primerapell']     = strtoupper($request->Apell1);
        $person['pers_segapell']        = strtoupper($request->Apell2);
        $person['pers_direccion']       = strtoupper($request->dir);
        $person['pers_telefono']        = strtoupper($request->tel);
        $person['ciud_id']              = (int) $request->ciudad;
        $person['dpto_id']              = (int) $request->dpto;
        $person['pers_email']           = strtoupper($request->eMail);
        $person['id_user']              = Auth::id();
        $person['pers_estado']          = 'A';
        $validate = PersonModel::getValidator($person, $request->TipoId);

        if ($validate->fails()) {

            return response()->json(['errors' => $validate->errors()], 500);
        }

        $person = Person::create($person);

        // Creo los datos de Employees
        $employee = [];
        $employee['client_estado'] = 'A';
        $employee['id_person']     = $person->id;
        // $employee['clie_dircorresp']  = $request->dirCorresp;

        $validate = EmployeeModel::getValidator($employee);

        if ($validate->fails()) {

            return response()->json(['errors' => $validate->errors()], 500);
        }

        Employee::create($employee);

        // Obtengo los datos nuevamente para mostrarlos en el listado de clientes
        $employees = Employee::orderBy('id','DESC')->paginate(7);
        $states = State::all();
        //dd($clients);
        return view('employees.trEmployee', ['employees' => $employees, 'states' => $states]);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $empl
     * @return \Illuminate\Http\Response
     */
    public function  searchEmployee(Request $request) {
        // PersonModel::getPerson('paso el id de persona'); me retorna la persona

        $empl = Employee::find($request->id);
        return   $empl->Person;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee) {

        // Actualizo los datos de Persona
        dd($request->all());
        $personUpd = [];
        $personUpd['id']                    = $request->idPerson;
        $personUpd['pers_identif']          = $request->idEmployee;
        $personUpd['pers_tipoid']           = $request->TipoId;
        $personUpd['pers_razonsocial']      = strtoupper($request->pers_razonsocial);
        $personUpd['pers_primernombre']     = strtoupper($request->Nom1);
        $personUpd['pers_segnombre']        = strtoupper($request->Nom2);
        $personUpd['pers_primerapell']      = strtoupper($request->Apell1);
        $personUpd['pers_segapell']         = strtoupper($request->Apell2);
        $personUpd['pers_direccion']        = strtoupper($request->dir);
        $personUpd['pers_telefono']         = strtoupper($request->tel);
        $personUpd['ciud_id']               = (int) $request->ciudad;
        $personUpd['dpto_id']               = (int) $request->dpto;
        $personUpd['pers_email']            = strtoupper($request->eMail);

        $validate = PersonModel::getValidator($personUpd, $request->TipoId);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 500);
        }

        $person = PersonModel::getPerson($request->idPerson);
        $person->update($personUpd);

        // Actualizo los datos de Empleado
        $EmployeeUpd = [];
        $EmployeeUpd['id'] = $request->idEmpl;
        $EmployeeUpd['id_person'] = $person->id;
        $EmployeeUpd['empl_finicio'] = $person->id;
        $EmployeeUpd['empl_ffin'] = $person->id;

        $validate = EmployeeModel::getValidator($EmployeeUpd);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 500);
        }

        $employee = EmployeeModel::getEmployee($request->idClient);
        $employee->update($EmployeeUpd);

        // Obtengo los datos nuevamente para mostrarlos en el listado de empleados
        $employees = Employee::orderBy('id', 'ASC')->paginate(7);
        $states = State::all();
        return view('employees.trEmployee', ['employees' => $employees, 'states' => $states]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $empl = Employee::find($request->id);
        $empl->empl_estado ='I';
        $empl->save();

        // Obtengo los datos nuevamente para mostrarlos en el listado de clientes
        $employees = Employee::orderBy('id', 'ASC')->paginate(7);
        $states = State::all();
        return view('employees.trEmployee', ['employees' => $employees, 'states' => $states]);
    }
}
