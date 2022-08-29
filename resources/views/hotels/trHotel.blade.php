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