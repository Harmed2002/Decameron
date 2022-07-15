<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\State;
use App\Models\City;
use App\Models\Person;
use App\Models\PersonModel;
use App\Models\EconomicAct;
use Auth;
use Illuminate\Http\Request;


class SupplierController extends Controller {
    /**
     * Creamos el constructor para inyectar la dependencia de la clase Supplier
     * para utilizarlo en los métodos de la clase SupplierController
     */
    protected $suppliers;
    protected $states;
    protected $cities;
    protected $economicacts;

    public function __construct(Supplier $suppliers, State $states, City $cities, EconomicAct $economicacts) {
        $this->suppliers = $suppliers;
        $this->states = $states;
        $this->cities = $cities;
        $this->economicacts = $economicacts;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $suppliers = Supplier::orderBy('id','DESC')->get();
        $states = State::all();
        $economicacts = $this->economicacts->getEconomicActs();
        //dd($economicacts);
        return view('suppliers.index', ['suppliers' => $suppliers, 'states' => $states, 'economicacts' => $economicacts]);
    }

    public function Cities($state_id) {
        $cities = $this->cities->getCities($state_id);

        return $cities;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $supplier = Supplier::find($request->id);
        $person = null;

        if (isset($request->show) && $request->show == 'true') {

            return view('suppliers.show', compact('supplier'));
        } else {
            $states = State::all();
            $economicacts = $this->economicacts->getEconomicActs();
            if ($supplier) {
                $person = $supplier->Person ;
            }
        
            $cities = City::all();
            // dd($supplier);
            return view('suppliers.form', compact('supplier', 'states', 'economicacts', 'person','cities'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $personData = $request->person;
        $state = $request->estado;   
        $personData['pers_estado'] = 'A';
        $personData['id_user'] = Auth::id();

        $person = Person::find($personData['id']);

        $validatePerson = PersonModel::getValidator($personData, $request->TipoId);
    
        if ($validatePerson->fails()) {
            return response()->json(['errors' =>   $validatePerson->errors()], 500);
        }

        if ($person) {
            $person->update($personData);
        } else {

            $person = Person::create($personData);
        }

        $supplierData = $request->supplier;
        $supplierData['id_person'] = $person->id;
        $supplierData['prov_estado'] = 'A';

        $supplier = Supplier::find($supplierData['id']);
        if ($supplier) {

            $supplier->update($supplierData);
        } else {
            Supplier::create($supplierData);
        }
        $suppliers = Supplier::orderBy('id','DESC')->paginate(7);
        return view('suppliers.trSupplier', compact('suppliers'));
        //   return response()->json($request->all(),500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $supplier = Supplier::find($request->idSupplier);
        $supplier->prov_estado = 'I';
        $supplier->save();

        $person = Person::find($supplier->Person->id);
        $person->pers_estado = 'I';
        $person->save();

        $suppliers = Supplier::orderBy('id','DESC')->paginate(7);
        return view('suppliers.trSupplier', compact('suppliers'));
    }
    public function searchEconomica(Request $request)
    {
        $actEconomic= EconomicAct::where('acte_nombre','like','%'.$request['search'].'%')->select('acte_nombre','id')->limit(10)->get();
        return response()->json($actEconomic);
    }
}
