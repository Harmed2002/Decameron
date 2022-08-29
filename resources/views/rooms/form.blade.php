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
        <div class="col-12 col-sm-10 mb-3">
            <label for="dir" style="font-size: 9pt">Dirección (*)</label>
            <input type="text" class="form-control" placeholder="Digite la dirección" name="dir" id="dir" required value="{{ $hotel->direccion ?? '' }}" tabindex="3">
        </div>
        <div class="col-12 col-sm-2 mb-3">
            <label for="numhab" style="font-size: 9pt">Habitaciones (*)</label>
            <input type="number" class="form-control" name="numhab" id="numhab" required value="{{ $hotel->numhab ?? '' }}" tabindex="4">
        </div>
        
    </div>
    
    <!-- Caja de nuevo detalle -->
    <div class="div" id="detail" style="border : 1px solid #B8DAFF; margin : 4px 4px 1px 4px;">
        <div class="div" style="margin : 8px 8px 1px 8px;">
            <div class="row">
                <div class="col-12 col-sm-4 mb-3">
                    <select class="form-control select2" id="tipoHab" required>
                        <option value="">Seleccione tipo hab...</option>
                        @foreach ($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}"> {{ $roomType->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <select class="form-control select2" id="tipoAcom" required>
                        <option value="">Seleccione acomodación...</option>
                        @foreach ($accommodationTypes as $accommodationType)
                            <option value="{{ $accommodationType->id }}"> {{ $accommodationType->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-2 mb-3">
                    <input type="number" class="form-control" name="cant" id="cant" placeholder="Cantidad">
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
                                <th>Acomodación</th>
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="tbody_roomdet" name="tbody_roomdet">
                        </tbody>

                        <tfoot class="table-primary-foot">
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin tabla -->
    </div>
    <br>

    <div class="row">
        <div class="col-6">
            <button class="btn btn-success" onclick="saveHotel()" type="button" id="saveHotelButton">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</form>
