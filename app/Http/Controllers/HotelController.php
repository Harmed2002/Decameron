<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelModel;
use App\Models\RoomType;
use App\Models\AccommodationType;
use App\Models\Room_Accommodation;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Room;
/*use Auth;*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HotelController extends Controller {

    /**
     * Creamos el constructor para inyectar las dependencias de las clases
     * para utilizarlo en los métodos
     */

    protected $cities, $accommodations, $rooms, $roomAccommodations;

    public function __construct(City $cities, AccommodationType $accommodations, Room $rooms, Room_Accommodation $roomAccommodations) {

       $this->cities = $cities;
       $this->accommodations = $accommodations;
       $this->roomAccommodations = $roomAccommodations;
       $this->rooms = $rooms;
    }


    public function index() {
        $hotels = Hotel::orderBy('id', 'ASC')->get();
        return view('hotels.index', ['hotels' => $hotels]);
    }


    public function create(Request $request) {
        $hotel = Hotel::find($request->id);
        $detail = [];
        $roomTypes = RoomType::orderBy('id', 'ASC')->get();
        $accommodationTypes = AccommodationType::orderBy('id', 'ASC')->get();

        if (isset($request->show) && $request->show == 'true') {
            return view('hotels.show', compact('hotel'));
        
        } else {
            $countries = Country::orderBy('id', 'ASC')->get();
            $states = State::orderBy('id', 'ASC')->get();
            $cities = City::orderBy('id', 'ASC')->get();

            if ($request->id) {
                $detail = $this->rooms->getRoomsByIdHotel($hotel->id);
            }

            return view('hotels.form', compact('hotel', 'roomTypes', 'accommodationTypes', 'countries', 'states', 'cities', 'detail'));
        }
    }

    
    public function store(Request $request) {
        $hotel              = [];
        $hotel['id']        = '';
        $hotel['nit']       = $request->nit;
        $hotel['nombre']    = strtoupper($request->nombre);
        $hotel['direccion'] = strtoupper($request->dir);
        $hotel['numhab']    = $request->numhab;
        $hotel['id_country']= $request->pais;
        $hotel['id_state']  = $request->dpto;
        $hotel['id_city']   = $request->ciudad;

        $validate = HotelModel::getValidator($hotel);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 500);
        }

        // Comienzo la transacción
        DB::beginTransaction();
        try {
            // Guardo los datos en el maestro de servicios
            $hotel = Hotel::create($hotel);

            // Guardo el detalle de hab
            $details = $request->details;
            
            if (!empty($details)) {
                foreach ($details as $key => $value) {

                    $details[$key]['id_hotel'] = $hotel->id;

                }

                foreach ($details as $key => $value) {
                
                    Room::create($value);

                }
           }

            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }

        // Obtengo los datos nuevamente para mostrarlos en el listado
        $hotels = Hotel::orderBy('id', 'ASC')->get();
        return view('hotels.trHotel', ['hotels' => $hotels]);

    }


    public function update(Request $request) {
        $hotelUpd              = [];
        $hotelUpd['id']        = $request->id;
        $hotelUpd['nit']       = $request->nit;
        $hotelUpd['nombre']    = strtoupper($request->nombre);
        $hotelUpd['direccion'] = strtoupper($request->dir);
        $hotelUpd['numhab']    = $request->numhab;
        $hotelUpd['id_country']= $request->pais;
        $hotelUpd['id_state']  = $request->dpto;
        $hotelUpd['id_city']   = $request->ciudad;

        $validate = HotelModel::getValidator($hotelUpd);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 500);
        }

        // Comienzo la transacción
        DB::beginTransaction();
        try {
            $hotel = HotelModel::getHotel($request->id);
            $hotel->update($hotelUpd);
            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            return response()->$e->getMessage();
        }

        // Obtengo los datos nuevamente para mostrarlos en el listado
        $hotels = Hotel::orderBy('id', 'ASC')->get();
        return view('hotels.trHotel', ['hotels' => $hotels]);

    }

    
    public function destroy(Request $request) {
        $hotel = Hotel::find($request->id);

        try {
            $hotel->delete();
        } catch (\Exception $e){
            return response()->$e->getMessage();
        }

        // Obtengo los datos nuevamente para mostrarlos en el listado
        $hotels = Hotel::orderBy('id', 'ASC')->get();
        return view('hotels.trHotel', ['hotels' => $hotels]);
    }


    public function trRoomDetails(Request $request) {
        $detail = $request->all();
        $count = $request->count;

        return view('hotels.trDetailRooms', compact('detail', 'count'));
    }


    public function Cities($state_id) {
        $cities = $this->cities->getCities($state_id);
        return $cities;
    }


    public function Accommodations($idRoomType) {
        $accommodationsByRoom = $this->roomAccommodations->getAccommodationsByRoom($idRoomType);

        return $accommodationsByRoom;
    }
}
