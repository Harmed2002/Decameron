@foreach ($employees as $employee)
    <tr id="tr_{{ $employee->id }}"
        @if ($employee->empl_estado == 'I') style="color:#e3342f" @endif>
        <td>{{ $employee->id }}</td>
        <td>{{ $employee->Person->pers_primernombre .' '. $employee->Person->pers_segnombre.' '.$employee->Person->pers_primerapell .' '.$employee->Person->pers_segapell  ?? '' }}</td>
        <td>{{ $employee->Person->pers_razonsocial }}</td>
        <td>{{ $employee->Person->pers_identif }} - {{ $employee->Person->pers_tipoid }}</td>
        <td>                                       
            <b>TEL: </b>{{ $employee->Person->pers_telefono }}<br>
            <b>EMAIL: </b>{{ $employee->Person->pers_email }}
        </td>
        <td>
            {{ $employee->Person->State->dpto_nombre }} -  {{ $employee->Person->City->ciud_nombre }}<br>
            {{ $employee->Person->pers_direccion }}
        </td>

        <td class="text-right py-0 align-middle">
            <div class="btn-group btn-group-sm">
                <button class="btn btn-info mr-1"
                    onclick="createEmployee( {{ $employee->id }}, true)" type="button">
                    <i class="fas fa-eye"></i>
                </button>
                <!-- Aca debo validar si tiene autorizacion para ejecutar el boton -->
                <button class="btn btn-primary mr-1"
                    onclick="createEmployee({{ $employee->id }},false,'{{ $employee->Person->pers_tipoid }}')"
                    type="button">
                    <i class="fas fa-edit"></i>
                </button>
                <!-- Aca debo validar si tiene autorizacion para ejecutar el boton -->
                <button class="btn btn-danger"
                    onclick="deleteEmployee({{ $employee->id }},'tr_{{ $employee->id }}')"
                    type="button">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach