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
