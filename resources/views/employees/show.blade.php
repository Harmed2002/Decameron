<b>Identificación</b>: {{ $employee->Person->pers_tipoid }} {{ $employee->Person->pers_identif }}
<br>
<b>Nombres y apellidos</b>:
    {{ $employee->Person->pers_primerapell }}
    {{ $employee->Person->pers_segapell }} {{ $employee->Person->pers_primernombre }}
    {{ $employee->Person->pers_segnombre }}
<br>
<b>Dirección</b>: {{ $employee->Person->pers_direccion }}
<br>
<b>Departamento</b>: {{ $employee->Person->State->dpto_nombre }} <b>Ciudad</b>: {{ $employee->Person->City->ciud_nombre }}
<br>
<b>Teléfono</b>: {{ $employee->Person->pers_telefono }} <b>Email</b>: {{ $employee->Person->pers_email }}
<br>
<hr>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>