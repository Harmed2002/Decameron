@extends('adminlte::page')
<!-- , ['iFrameEnabled' => true] -->
@section('title', 'Listado de Hoteles')

@section('content_header')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/select2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/datatables/buttons.bootstrap4.min.css') }}">
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h1 class="card-title"><i class="fab fa-whmcs"></i>  Listado de Hoteles</h1>
        </div>

        <div class="card-body">
            <div  class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-6 mb-2">
                        <button class="btn btn-primary" onclick="createHotel()" type="button">Crear</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-12 col-md-12">
                        <div class="table-responsive">
                            <table id="hotelTable" class="table table-bordered table-striped dataTable dtr-inline">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nit</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Núm. Hab.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_hotel" name="tbody_hotel">
                                    @foreach ($hotels as $hotel)
                                        <tr id="tr_{{ $hotel->id }}">
                                            <td>{{ $hotel->id }}</td>
                                            <td>{{ $hotel->nit }}</td>
                                            <td>{{ $hotel->nombre }}</td>
                                            <td>
                                                {{ $hotel->direccion }} <br>
                                                {{ $hotel->City->nombre }} - {{ $hotel->City->State->nombre }} ({{ $hotel->City->State->Country->nombre }})
                                            </td>
                                            <td>{{ $hotel->numhab }}</td>
                            
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-info mr-1" onclick="createHotel({{ $hotel->id }}, true)" type="button"><i class="fas fa-eye"></i></button>
                                                    <!-- Aca debo validar si tiene autorizacion para ejecutar el boton -->
                                                    <button class="btn btn-primary mr-1" onclick="createHotel({{ $hotel->id }}, false)" type="button"><i class="fas fa-edit"></i></button>
                                                    <!-- Aca debo validar si tiene autorizacion para ejecutar el boton -->
                                                    <button class="btn btn-danger" onclick="deleteHotel({{ $hotel->id }},'tr_{{ $hotel->id }}')" type="button"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('layouts.modal')

@section('js')
    <script src="{{ asset('js/plugins/datatables/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/admin/validate.js') }}"></script>
    <script src="{{ asset('js/admin/admin.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script src="{{ asset('js/hotel/functions.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons.colVis.min.js') }}"></script>
@endsection
