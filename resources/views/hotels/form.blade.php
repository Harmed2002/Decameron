<form class="form-send-hotel">
    @csrf
    <input type="hidden" class="form-control" name="id" id="id" value="{{ $hotel->id ?? '' }}">

    <div class="row">
        <div class="col-12 col-sm-4 mb-3">
            <label for="nit" style="font-size: 9pt">Nit (*)</label>
            <input type="text" class="form-control" placeholder="Digite el nit" name="nit" id="nit" required value="{{ $hotel->nit ?? '' }}" tabindex="1">
        </div>
        <div class="col-12 col-sm-8 mb-3">
            <label for="nombre" style="font-size: 9pt">Nombre (*)</label>
            <input type="text" class="form-control" placeholder="Digite el nombre del hotel" name="nombre" id="nombre" required value="{{ $hotel->nombre ?? '' }}" tabindex="2">
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-4 mb-3">
            <label for="pais" style="font-size: 9pt">País (*)</label>
            @php
                $selected = $hotel->id_country ?? '';
            @endphp
            <select class="form-control select2" name="pais" id="pais" required tabindex="3">
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $selected == $country->id ? 'selected' : '' }}>{{ $country->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-4 mb-3">
            <label for="dpto" style="font-size: 9pt">Departamento (*)</label>
            @php
                $selected = $hotel->id_state ?? '';
            @endphp
            <select class="form-control select2" name="dpto" id="dpto" required onchange="showCities()" tabindex="4">
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $selected == $state->id ? 'selected' : '' }}>{{ $state->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-4 mb-3">
            <label for="ciudad" style="font-size: 9pt">Ciudad (*)</label>
            @php
                $selected = $hotel->id_city ?? '';
            @endphp
            <select class="form-control select2" name="ciudad" id="ciudad" required tabindex="5">

                @foreach ($cities as $city)
                    <option value="{{ $city['id'] }}" {{ $selected == $city['id'] ? 'selected' : '' }}>{{ $city['nombre'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-10 mb-3">
            <label for="dir" style="font-size: 9pt">Dirección (*)</label>
            <input type="text" class="form-control" placeholder="Digite la dirección" name="dir" id="dir" required value="{{ $hotel->direccion ?? '' }}" tabindex="6">
        </div>
        <div class="col-12 col-sm-2 mb-3">
            <label for="numhab" style="font-size: 9pt">Habitaciones (*)</label>
            <input type="number" class="form-control" name="numhab" id="numhab" required value="{{ $hotel->numhab ?? '0' }}" min="0" value="0" tabindex="7">
        </div>
    </div>

    <!-- Caja de nuevo detalle -->
    <div class="card-header">
        <h1 class="card-title">Gestión de Habitaciones</h1>
    </div>
    <div class="div" id="detail" style="border : 1px solid #B8DAFF; margin : 4px 4px 1px 4px;">
        <div class="div" style="margin : 8px 8px 1px 8px;">
            <div class="row">
                <div class="col-12 col-sm-4 mb-3">
                    <select class="form-control select2" id="tipoHab" name="tipoHab" onchange="showAccommodations()" required>
                        <option value="">Seleccione tipo hab...</option>
                        @foreach ($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}"> {{ $roomType->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <select class="form-control select2" id="tipoAcom" name="tipoAcom" required>
                        <option value="">Seleccione acomodación...</option>
                        @foreach ($accommodationTypes as $accommodationType)
                            <option value="{{ $accommodationType->id }}"> {{ $accommodationType->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-2 mb-3">
                    <input type="number" class="form-control" name="cant" id="cant" placeholder="Cantidad" min="0" value="0">
                </div>

                <!--div class="col-3 col-sm-3 "-->
                <div class="col-12 col-sm-2 mb-3">
                    <button class="btn btn-primary btn-sm" onclick="addDetail()" type="button" id="addDetailButton">Agregar</button>
                </div>
            </div>
        </div>

        <!-- Tabla detalle rooms-->
        <div class="card card-info mt-2">
            <div class="card-body p-0" style="display: block;">
                <div class="table-responsive">
                    <table class="table" id="detailTable">
                        <thead class="table-primary">
                            <tr>
                                <th>Tipo Hab.</th>
                                <th>Descripción</th>
                                <th>Tipo Acom.</th>
                                <th>Descripción</th>
                                <th>Cant.</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="tbody_roomdet" name="tbody_roomdet">
                            @if($detail)
                                @php          
                                    $count = 0;
                                @endphp
                                @foreach ($detail as $detail)
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td><input value = "{{ $detail['id_tipohab'] }}" name = "details[{{ $count }}][id_tipohab]" style = "width: 50px; border:0; background-color: #ffffff;" readonly></td>
                                        <td><input value = "{{ $detail['TipoHab'] }}" name = "details[{{ $count }}][TipoHab]" style = "width: 200px; border:0; background-color: #ffffff;" readonly></td>
                                        <td><input value = "{{ $detail['id_acomodacion'] }}" name = "details[{{ $count }}][id_acomodacion]" style = "width: 50px; border:0; background-color: #ffffff;" readonly></td>
                                        <td><input value = "{{ $detail['Acomod'] }}" name = "details[{{ $count }}][Acomod]" style = "width: 200px; border:0; background-color: #ffffff;" readonly></td>
                                        <td><input value = "{{ $detail['cant'] }}"  name = "details[{{ $count }}][cant]" style = "width: 50px; border:0; background-color: #ffffff;" readonly></td>
                                        
                                        <td class="text-right py-0 align-middle">
                                            <button class="btn btn-danger" onclick="deleteRow(this)" type="button"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                        <tfoot class="table-primary-foot">
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin tabla -->

        <div class="col-12 col-sm-2 mb-3">
            <label for="total" style="font-size: 8pt">Vlr. Total Detalle</label>
            <input type="text" class="form-control" name="total" id="total" value="0" disabled>
        </div>
    </div>


    <div class="row">
        <div class="col-6">
            <button class="btn btn-success" onclick="saveHotel()" type="button" id="saveHotelButton">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</form>
