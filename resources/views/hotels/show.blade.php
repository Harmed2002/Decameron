<b>Id:</b> {{ $hotel->id }}<br>
<b>Nit:</b> {{ $hotel->nit }}<br>
<b>Nombre:</b> {{ $hotel->nombre }}<br>
<b>Dirección:</b> {{ $hotel->direccion }} {{ $hotel->City->nombre }} - {{ $hotel->City->State->nombre }} ({{ $hotel->City->State->Country->nombre }})<br>
<b>Núm. de Hab.:</b> {{ $hotel->numhab }}
<hr>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>