//const { compileString } = require("sass");

$(document).ready(function () {
    $("#hotelTable").DataTable({
        "language": {
            "url": "js/plugins/datatables/es.json"
        },
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "iDisplayLength": 7,
        "bSort" : false
    }).buttons().container().appendTo('#hotelTable_wrapper .col-md-6:eq(0)');

});


function createHotel(id = null, show = null) {
    if (id == null && show == null) {
        openModal("Creación de Hotel")
    }

    if (show == true) {
        openModal("Datos de Hotel")
    }

    if (show == false) {
        openModal("Modificación de Hotel");
    }

    url = id == null ? 'formHotel' : 'formHotel/' + id + '/' + show;

    $.ajax({
        type: 'GET',
        url: url,
        success: (data) => {
      
            $('#adminModalBody').html('');
            $('#adminModalBody').html(data);

            initSelectTwoModal();

        },
        error: (data) => {
            alertDanger()
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }
         }
    });
    return 0;

}


function saveHotel(){
    let id= document.getElementById('id').value;

    url = id == 0 ? 'saveHotel' : 'updateHotel/' + id;
    var data = $('.form-send-hotel').serialize();

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {

            hideModal();
            $('#tbody_hotel').html('');
            $('#tbody_hotel').append(data);

            alertSuccess()

        },
        error: (data) => {
            alertDanger()
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }
        }
    });
    return 0;
}


function deleteHotel(id) {
    swal({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Anular!'
    }).then((result) => {

        if (result) {
            $.ajax({
                type: 'GET',
                url: 'deleteHotel/' + id,
                success: (data) => {
              
                    $('#tbody_hotel').html('');
                    $('#tbody_hotel').append(data);

                    swal({
                        title: '¡Anulado!',
                        text: 'Se ha cambiado el estado con éxito',
                        icon: "success",
                    })

                },
                error: (data) => {
                    alertDanger()
                    if (typeof (data.responseJSON.errors) == 'object') {
                        onFail(data.responseJSON.errors)
                    } else {
                        onDangerUniqueMessage(data.responseJSON.message)
                    }
                }
            });

        }
    })

    return 0;
}


var count = 0;
var listCodigos = []; // Creo el arreglo que va a contener el detalle de habitaciones por hotel
// Lleno el arreglo con espacios
for (var i = 0; i < 100; i++) {
    listCodigos[i] = [];
}


function addDetail() {
    let idTipoHab = $('#tipoHab').val()
    let idAcomod = $('#tipoAcom').val()
    let cmbTipoHab = document.getElementById("tipoHab");
    let descrTipoHab = cmbTipoHab.options[cmbTipoHab.selectedIndex].text;
    let cmbAcomod = document.getElementById("tipoAcom");
    let descrAcomod = cmbAcomod.options[cmbAcomod.selectedIndex].text;
    let cant = $('#cant').val()
    let ValidDetail = idTipoHab + idAcomod;
    let found = 0;
    let cnt = 0;

    if (!idTipoHab || !idAcomod || cant == 0) {
        swal({
            title: "ERROR!",
            text: "Algun(os) campo(s) está(n) vacío(s)",
            type: "error",
            button: "Cerrar!",
        });

        return false;
    }

    // Verifico si ya existen los id en el detalle
    found = validExistInArray(ValidDetail);
    if (found) {
        swal({
            title: "ERROR!",
            text: "Este tipo de habitación y acomodación ya existen en el detalle",
            type: "error",
            button: "Cerrar!",
        });

        return false;
    }

    cnt = validQuantityRooms(cant);
    if (!cnt) {
        swal({
            title: "ERROR!",
            text: "El total de habitaciones en el detalle superó la cantidad de habitaciones del hotel.",
            type: "error",
            button: "Cerrar",
        });

        return false;
    }

    count = count + 1;

    var data = {
        id_tipohab: idTipoHab,
        id_acomodacion: idAcomod,
        TipoHab: descrTipoHab,
        Acomod: descrAcomod,
        cant: cant,
        count : count
    }
    
    $.ajax({
        type: 'GET',
        url: 'roomDetails',
        data: data,
        success: (data) => {
            $('#tbody_roomdet').append(data);

        },
        error: (data) => {
            console.log('error', data)
        }
    }).done(function (data) {
        if (listCodigos.length < count) {
            listCodigos.push([ValidDetail, cant]); // Ingreso los elementos en el array
        } else {
            listCodigos[count - 1].push(ValidDetail, cant); // Ingreso los elementos en el array
        }
        
        let cantItem = cant;
        let cantActual = $('#total').val();
        let total = parseFloat(cantItem) + parseFloat(cantActual);
        $('#total').val(total);
        // Blanqueo los campos
        $('#cant').val(0);
        
    });

    return 0;
}


function deleteRow(r) {
    swal({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar!'
    }).then((result) => {
        if (result) {
            
            let i = r.parentNode.parentNode.rowIndex;
            let cant = listCodigos[i - 1][1]
            let total = $('#total').val()

            // Elimiino la fila  en el detalle de la tabla
            document.getElementById('detailTable').deleteRow(i);

            // Elimino el item del array
            listCodigos.splice(i - 1, 1)

            // Resto del campo de total
            $('#total').val(total - cant)
            count = count - 1;

        }

    })
}


function validExistInArray(cad) {
    let cadena = '';

    for(let i = 0; i < listCodigos.length; i++){
        cadena = listCodigos[i];
        if (cad == cadena[0]) {
            return 1;
        } else {
            return 0;
        }
        
    };

}


function validQuantityRooms(cant) {
    let numHabs = $('#numhab').val();
    let cantActual = $('#total').val();

    console.log(parseFloat(cantActual) + parseFloat(cant));

    if (numHabs < parseFloat(cantActual) + parseFloat(cant)){
        return 0;
    } else {
        return 1;
    }
    
}


function showAccommodations() {
    $("#tipoAcom").html("");
    var idRoomType = $("#tipoHab").val();

    if (idRoomType) {
        $.ajax({
            url: "getAccommodations/" + idRoomType,
            type: "GET",
            dataType: "json",
            success: function (dataJson) {
               
                var option = "";
                $.each(dataJson, function (k, v) {
                    option +=
                        "<option value=" +
                            parseInt(v.id_accommodation) +
                        ">" +
                            v.nombre +
                        "</option>";
                });
                $("#tipoAcom").html("");
                $("#tipoAcom").html(option);
            },
        });
    } else {
        $("#tipoAcom").html('<option value="">Seleccione acomodación...</option>');
    }
}

