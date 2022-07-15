$(document).ready(function () {


    $("#table-supplier").DataTable({
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
    }).buttons().container().appendTo('#table-supplier_wrapper .col-md-6:eq(0)');


});

function createSupplier(id_supplier = null, show = null,type=null) {
    

    if (id_supplier == null && show == null) {
       
        openModal("Creación de proveedor.")
    }
    if (show == true) {

        openModal("Ver proveedor.")
    }
    if (show == false) {

        openModal("Editar proveedor.");

    }
    url = id_supplier = null ? 'formSupplier' : 'formSupplier/' + id_supplier + '/' + show;

    $.ajax({
        type: 'get',
        url: url,
        success: (data) => {
      
            $('#adminModalBody').html('');
            $('#adminModalBody').html(data);
            typeDocument(type);
            initSelectTwoModal()

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
function sendSupplier(){
    // var pers_razonsocial =$('#pers_razonsocial').val();
    // $('.rSocial').val(pers_razonsocial )
    var data = $('.form-send-supplier').serialize();

    $.ajax({
        type: 'post',
        url: 'saveSupplier',
        data: data,
  
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {

            hideModal();
            $('#tbody_supplier').html('');
            $('#tbody_supplier').append(data);

            alertSuccess()

            // $("#adminModalBody").modal("hide");
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
function deleteSupplier(id_supplier) {

    swal({
        title: '¿Estás seguro?',
        text: "¡Se le cambiara el estado del proveedor!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Desea inactivarlo'
    }).then((result) => {
        console.log(result);
        if (result) {


            $.ajax({
                type: 'get',
                url: 'deleteSupplier/' + id_supplier,
                success: (data) => {
              
                    $('#tbody_supplier').html('');
                    $('#tbody_supplier').append(data);

                    swal({

                        title: '¡Estado cambiado!',
                        text: 'Ha pasado a inactivo con éxito',
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

// Metodo para guardar obra
// function saveSupplier(){
//     let id = document.getElementById('id').value;
//     var data = $('.form-send-supplier').serialize();

//     url = id == 0 ? 'saveSupplier' : 'updateSupplier/' + id;

//     $.ajax({
//         type: 'post',
//         url: url, 
//         data:data,
//         headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
//         success: (data) => {
//             hideModal();
//             // Lllega aca y la pego
//             $('#tbody_supplier').html('');
//             $('#tbody_supplier').html(data);
    
//             alertSuccess()
//         },
//         error: (data) => {
//             onFail(data.responseJSON.errors)
//         }
//     });

//     return 0;
// }


//Metodo de eliminar
// function deleteSupplier(){
//     swal({
//         title: '¿Estás seguro',
//         text: "¡No podrás revertir esto!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Desea eliminarlo'
//       }).then((result) => {
//           console.log(result);
//         if (result) {

//             $.ajax({
//                 type: 'get',
//                 url: 'deleteMachineryNovelty/'+prod_id,
//                 success: (data) => {
         
//                     $('#tbody_production').html('');
//                     $('#tbody_production').html(data);
//                     swal({

//                         title: '¡Cambiado!',
//                         text: 'Se ha cambiado el estado con éxito',
//                         icon: "success",
//                       })
                
//                 },
//                 error: (data) => {
//                     alertDanger()
//                  }
//             });
//             return 0;

//         }
//       })
// }


function searchEconomica(){
            var actEconomica =$('#prov_codactividad_select').val();
            var  option = '';
            if(actEconomica.length>4){
                $.ajax({
                    type: 'post',
                    url: 'searchEconomica',
                    data:{
                        search:actEconomica
                    },
                   headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success: (data) => {
    
                        data.forEach(element => {
                            option += "<option class='form-control' value="+element.id+">"+element.acte_nombre+"</option>";
                        });
                        // option +='</ul>';
                        $('#prov_codactividad').html('');
                        $('#prov_codactividad').append(option);
              
                        
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
            }else{
                $('#prov_codactividad').html('');
            }

            return 0;
}
function codeVerification(){

    var nit  = $('#idProv').val();
    var result = 0;
    if(nit.length >= 9){
        let array = nit.split('');
        let sum = 0;
 
        var arraySeriel = [41, 37, 29, 23, 19, 17, 13, 7, 3]
        for (let index = 0; index < array.length; index++) {

            var element =  parseInt(array[index]) * arraySeriel[index];
            sum +=element 
            
            console.log(element)
        }
        let div =  sum/11;
        var decPart =parseFloat('0.'+(div+"").split(".")[1]);
        var mul =Math.round(decPart*11);

        if (mul == 0 || mul ==1) {
            result = mul;
        }else{

            result = 11 - mul;
        }

        $('.codeVerification').val(result)

    }else{

        $('.codeVerification').val('')
    }
  
}