@extends('adminlte::page')
<!-- , ['iFrameEnabled' => true] -->
@section('title', 'Listado de Empleados')

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
            <h1 class="card-title"><b>Listado de Empleados</b></h1>
        </div>

        <div class="card-body">
            <div  class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-6 mb-2">
                        <button class="btn btn-primary" onclick="createEmployee()" type="button">Crear</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="employeeTable"
                                class="table table-bordered table-striped dataTable dtr-inline">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombres y apellidos</th>
                                        <th>Identificación</th>
                                        <th>Cargo</th>
                                        <th>Salario</th>
                                        <th>Inicio Lab.</th>
                                        <th>Final Lab.</th>
                                        <th>Dirección</th>
                                        <th>Datos adicionales</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_employee" name="tbody_employee">
                                    @foreach ($employees as $empl)
                                        <tr id="tr_{{ $empl->id }}"
                                            @if ($empl->empl_estado == 'I') style="color:#e3342f" @endif>
                                            <td>{{ $empl->id }}</td>
                                            <td>{{ $empl->Person->pers_primernombre .' '. $empl->Person->pers_segnombre.' '.$empl->Person->pers_primerapell .' '.$empl->Person->pers_segapell  ?? '' }}</td>
                                            <td>{{ $empl->Person->pers_tipoid }} {{ $empl->Person->pers_identif }}</td>
                                            <td>{{ $empl->position->posi_nombre }}</td>
                                            <td>{{ number_format($empl->empl_vlrsalario).' ('.$empl->empl_tiposalario.')' }}</td>
                                            <td>{{ $empl->empl_finicio }}</td>
                                            <td>{{ $empl->empl_ffin }}</td>
                                            <td>{{ $empl->Person->pers_direccion }}<br>{{ $empl->Person->State->dpto_nombre }} -  {{ $empl->Person->City->ciud_nombre }}</td>
                                            <td><b>TEL: </b>{{ $empl->Person->pers_telefono }}<br><b>EMAIL: </b>{{ $empl->Person->pers_email }}</td>
                            
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-info mr-1" onclick="createEmployee({{ $empl->id }}, true)" type="button"><i class="fas fa-eye"></i></button>
                                                    <!-- Aca debo validar si tiene autorizacion para ejecutar el boton -->
                                                    <button class="btn btn-primary mr-1" onclick="createEmployee({{ $empl->id }}, false)" type="button"><i class="fas fa-edit"></i></button>
                                                    <!-- Aca debo validar si tiene autorizacion para ejecutar el boton -->
                                                    <button class="btn btn-danger" onclick="deleteEmployee({{ $empl->id }},'tr_{{ $empl->id }}')" type="button"><i class="fas fa-trash"></i></button>
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
{{-- @include('employees.form') --}}
@section('js')
    <script src="{{ asset('js/plugins/datatables/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/admin/validate.js') }}"></script>
    <script src="{{ asset('js/admin/admin.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script src="{{ asset('js/employee/function.js') }}"></script>
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
