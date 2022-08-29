$(document).ready(function () {
    initSelectTwoModal();
        $("#table-permission").DataTable({
            "language": {
                "url": "js/plugins/datatables/es.json"
            },
            "dom": 'Bfrtip',
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            // "pagingType":"full_numbers",
            "iDisplayLength": 7,
            "bSort" : false
        }).buttons().container().appendTo('#table-permission_wrapper .col-md-6:eq(0)');

        $("#table-rols").DataTable({
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
        }).buttons().container().appendTo('#table-rols_wrapper .col-md-6:eq(0)');

    $("#table-user-admin")
        .DataTable({
            language: {
                url: "js/plugins/datatables/es.json",
            },
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "iDisplayLength": 7,
            "bSort" : false
        })
        .buttons()
        .container()
        .appendTo("#table-user-admin_wrapper .col-md-6:eq(0)");
});
// User
// function showUser(data) {
//     openModal("Ver Usuario")
//     $('#sendUserButton').hide();
//     $('#name').val(data.name);
//     $('#email').val(data.email);
//     $("#name").prop("disabled", true);
//     $("#email").prop("disabled", true);
//     $("#password").prop("disabled", true);
//     $("#password_confirmed").prop("disabled", true);
//     $('#password').hide();
//     $('#password_confirmed').hide();
// }

// function editUser(data) {
//     openModal("Editar Usuario")
//     $("#name").prop("disabled", false);
//     $("#email").prop("disabled", false);
//     $("#password").prop("disabled", false);
//     $("#password_confirmed").prop("disabled", false);
//     $('#name').val(data.name);
//     $('#email').val(data.email);
//     $('#id').val(data.id);
//     $('#sendUserButton').show();
//     $('#password').show();
//     $('#password_confirmed').show();
// }

function createUser(id = null, show = null) {
    if (id == null && show == null) {
        openModal("Crear usuario.");
    }
    if (show == "true") {
        openModal("Ver usuario.");
    }
    if (show == "false") {
        openModal("Editar usuario.");
    }
    url = id == null ? "formUser" : "formUser/" + id + "/" + show;

    $.ajax({
        type: "get",
        url: url,
        success: (data) => {
            $("#adminModalBody").html("");
            $("#adminModalBody").html(data);

            initSelectTwoModal();
        },
        error: (data) => {
            $("#adminModalBody").html("");
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
    // $('#id').val(0);
    // $("#name").prop("disabled", false);
    // $("#email").prop("disabled", false);
    // $("#password").prop("disabled", false);
    // $("#password_confirmed").prop("disabled", false);
    // $('#sendUserButton').show();
}

function deleteUser(id, tr) {
    $("#" + tr).remove();
    var url = "deleteUser/" + id;
    deleteData(url);
}

function sendUser() {
    var id = $("#id").val();

    if (id == "") {
        var validate = $(".form-send-admin-user").valid();
        if (!validate) {
            $(".form-send-admin-user").validate();
            return 0;
        } else {
            var data = $(".form-send-admin-user").serialize();
            $.ajax({
                type: "post",
                url: "saveUser",
                data: data,
                success: (data) => {
                    $("#tbody_user").html("");
                    $("#tbody_user").html(data);
                    resetform();
                    hideModal();
                },
                error: (data) => {
                    if (typeof (data.responseJSON.errors) == 'object') {
                        onFail(data.responseJSON.errors)
                    } else {
                        onDangerUniqueMessage(data.responseJSON.message)
                    }
        
                },
            });
            return 0;
        }
    } else {
        var data = $(".form-send-admin-user").serialize();
        $.ajax({
            type: "post",
            url: "saveUser",
            data: data,
            success: (data) => {
                $("#tbody_user").html("");
                $("#tbody_user").html(data);
                resetform();
                hideModal();
            },
            error: (data) => {
                if (typeof (data.responseJSON.errors) == 'object') {
                    onFail(data.responseJSON.errors)
                } else {
                    onDangerUniqueMessage(data.responseJSON.message)
                }
    
            },
        });
        return 0;
    }
    // $(".form-send-admin-user")[0].reset();
}

//------------------------------------CRUD ROLES-----------------------------------------------//
// function showRole(role) {
//     openModal("Ver Role")
//     $('#sendRoleButton').hide();
//     $('#name').val(role.name);
//     $('#guard_name').val(role.guard_name);
//     $("#name").prop("disabled", true);
//     $("#guard_name").prop("disabled", true);
// }

// function editRole(role) {
//     openModal("Editar Role")
//     $("#name").prop("disabled", false);
//     $("#guard_name").prop("disabled", false);
//     $('#name').val(role.name);
//     $('#guard_name').val(role.guard_name);
//     $('#id').val(role.id);
//     $('#sendRoleButton').show();
// }

function createRole(id = null, show = null) {
    if (id == null && show == null) {
        openModal("Crear rol.");
    }
    if (show == "true") {
        openModal("Ver rol.");
    }
    if (show == "false") {
        openModal("Editar rol.");
    }
    url = id == null ? "formRole" : "formRole/" + id + "/" + show;

    $.ajax({
        type: "get",
        url: url,
        success: (data) => {
            $("#adminModalBody").html("");
            $("#adminModalBody").html(data);
            initSelectTwoModal();
        },
        error: (data) => {
            $("#adminModalBody").html("");
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
}

function deleteRole(id, tr) {
    $("#" + tr).remove();
    var url = "deleteRole/" + id;
    deleteData(url);
}

function sendRole() {
    var validate = $(".form-send-admin-role").valid();
    var id = $("#id").val();

    if (id == "") {
        if (!validate) {
            $(".form-send-admin-role").validate();
        } else {
            var data = $(".form-send-admin-role").serialize();
            $.ajax({
                type: "post",
                url: "saveRole",
                data: data,
                success: (data) => {
                    $("#tbody_role").html("");
                    $("#tbody_role").html(data);
                    resetform();
                    hideModal();
                },
                error: (data) => {
                    if (typeof (data.responseJSON.errors) == 'object') {
                        onFail(data.responseJSON.errors)
                    } else {
                        onDangerUniqueMessage(data.responseJSON.message)
                    }
        
                },
            });
            return 0;
        }
    } else {
        var data = $(".form-send-admin-role").serialize();
        $.ajax({
            type: "post",
            url: "saveRole",
            data: data,
            success: (data) => {
                $("#tbody_role").html("");
                $("#tbody_role").html(data);
                resetform();
                hideModal();
            },
            error: (data) => {
                if (typeof (data.responseJSON.errors) == 'object') {
                    onFail(data.responseJSON.errors)
                } else {
                    onDangerUniqueMessage(data.responseJSON.message)
                }
    
            },
        });
        return 0;
    }
    // $(".form-send-admin-user")[0].reset();
}
//------------------------------------CRUD PERMISSIONS-------------------------------------------//
// function showPermission(permission) {
//     openModal("Ver Permiso")
//     $('#sendPermissionButton').hide();
//     $('#name').val(permission.name);
//     $('#guard_name').val(permission.guard_name);
//     $("#name").prop("disabled", true);
//     $("#guard_name").prop("disabled", true);
// }

// function editPermission(permission) {
//     openModal("Editar Permiso")
//     console.log('permission', permission);
//     $("#name").prop("disabled", false);
//     $("#guard_name").prop("disabled", false);
//     $('#name').val(permission.name);
//     $('#guard_name').val(permission.guard_name);
//     $('#id').val(permission.id);
//     $('#sendPermissionButton').show();
// }

function createPermission(id = null, show = null) {
    if (id == null && show == null) {
        openModal("Crear permiso.");
    }
    if (show == "true") {
        openModal("Ver permiso.");
    }
    if (show == "false") {
        openModal("Editar permiso.");
    }
    url = id == null ? "formPermission" : "formPermission/" + id + "/" + show;

    $.ajax({
        type: "get",
        url: url,
        success: (data) => {
            $("#adminModalBody").html("");
            $("#adminModalBody").html(data);

            initSelectTwoModal();
        },
        error: (data) => {
            $("#adminModalBody").html("");
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
    // $('#id').val(0);
    // $("#name").prop("disabled", false);
    // $("#guard_name").prop("disabled", false);
    // $('#sendPermissionButton').show();
}

function deletePermission(id, tr) {
    $("#" + tr).remove();
    var url = "deletePermission/" + id;
    deleteData(url);
}

function sendPermission() {
    var validate = $(".form-send-admin-permission").valid();
    var id = $("#id").val();
    if (id == "") {
        if (!validate) {
            $(".form-send-admin-permission").validate();
        } else {
            var data = $(".form-send-admin-permission").serialize();
            $.ajax({
                type: "post",
                url: "savePermission",
                data: data,
                success: (data) => {
                    {
                        $("#tbody_permission").html("");
                        $("#tbody_permission").html(data);
                        resetform();
                        hideModal();
                    }
                },
                error: (data) => {
                    if (typeof (data.responseJSON.errors) == 'object') {
                        onFail(data.responseJSON.errors)
                    } else {
                        onDangerUniqueMessage(data.responseJSON.message)
                    }
        
                },
            });
            return 0;
        }
    } else {
        var data = $(".form-send-admin-permission").serialize();
        $.ajax({
            type: "post",
            url: "savePermission",
            data: data,
            success: (data) => {
                {
                    $("#tbody_permission").html("");
                    $("#tbody_permission").html(data);
                    resetform();
                    hideModal();
                }
            },
            error: (data) => {
                if (typeof (data.responseJSON.errors) == 'object') {
                    onFail(data.responseJSON.errors)
                } else {
                    onDangerUniqueMessage(data.responseJSON.message)
                }
    
            },
        });
        return 0;
    }
    // $(".form-send-admin-user")[0].reset();
}


function showCities() {
    $("#ciudad").html("");
    var stateID = $("#dpto").val();
    console.log(stateID);
    if (stateID) {
        $.ajax({
            url: "getCities/" + stateID,
            type: "GET",
            dataType: "json",
            success: function (dataJson) {
               
                var option = "";
                $.each(dataJson, function (k, v) {
                    option +=
                        "<option value=" +
                            parseInt(v.id_state) +
                        ">" +
                            v.nombre +
                        "</option>";
                });
                $("#ciudad").html("");
                $("#ciudad").html(option);
            },
        });
    } else {
        $("#ciudad").html('<option value="">Seleccione Ciudad...</option>');
    }
}



//Roles permisos.

function createRolePermission(
    permission_id = null,
    role_id = null,
    show = null
) {
    if (role_id == null && permission_id == null && show == null) {
        openModal("Asociar de usuario con rol.");
    }
    if (show == "true") {
        openModal("Ver Asociación de usuario con rol.");
    }
    if (show == "false") {
        openModal("Editar Asociación de usuario con rol.");
    }
    url =
        role_id == null && permission_id == null
            ? "formRolPermission"
            : "formRolPermission/" + permission_id + "/" + role_id + "/" + show;

    $.ajax({
        type: "get",
        url: url,
        success: (data) => {
            $("#adminModalBody").html("");
            $("#adminModalBody").html(data);
            if (show) {
                $("#sendRolePermissionButton").remove();
            } else {
                initSelectTwoModal();
            }
        },
        error: (data) => {
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
}

function sendRolePermission() {
    var data = $(".form-send-role-permission").serialize();
    $.ajax({
        type: "post",
        url: "saveRolPermission",
        data: data,
        success: (data) => {
            $("#tbody_rolePermisions").html("");
            $("#tbody_rolePermisions").html(data);
            // $("#adminModal").modal("hide");
            hideModal();
        },
        error: (data) => {
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
}

function deleteRolePermission(id_role, id_permission, idTr) {
    $("#" + idTr).remove();
    var url = "deleteRolPermission/" + id_role + "/" + id_permission;
    deleteData(url);
}

// Usuario rol
function createUserRole(role_id = null, model_id = null, show = null) {
    if (show == true) {
        openModal("Ver Asociación de usuario con rol.");
    }

    if (role_id == null && model_id == null && show == null) {
        openModal("Asociar de usuario con rol.");
    }

    if (show == false) {
        openModal("Editar Asociación de usuario con rol.");
    }
    url =
        role_id == null && model_id == null
            ? "formUserRol"
            : "formUserRol/" + role_id + "/" + model_id + "/" + show;
    console.log("url", url);
    $.ajax({
        type: "get",
        url: url,
        success: (data) => {
            $("#adminModalBody").html("");
            $("#adminModalBody").html(data);
            if (show) {
                $("#sendUserRoleButton").remove();
                openModal("Ver Asociación de usuario con rol.");
                $("#id_user_asoc").prop("disabled", true);
                $("#id_role_asoc").prop("disabled", true);
            } else {
                initSelectTwoModal();
            }

            // $("#adminModalBody").modal("hide");
        },
        error: (data) => {
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
}

function sendUserRole() {
    var data = $(".form-send-user-rol").serialize();
    $.ajax({
        type: "post",
        url: "saveUserRol",
        data: data,
        success: (data) => {
            $("#tbody_userRole").html("");
            $("#tbody_userRole").html(data);
            $("#adminModal").modal("hide");
            hideModal();
        },
        error: (data) => {
            if (typeof (data.responseJSON.errors) == 'object') {
                onFail(data.responseJSON.errors)
            } else {
                onDangerUniqueMessage(data.responseJSON.message)
            }

        },
    });
    return 0;
}

function deleteUserRole(id_user, id_rol, idTr) {
    $("#" + idTr).remove();
    var url = "deleteUserRol/" + id_user + "/" + id_rol;
    deleteData(url);
}


function modalPermission(permissions, titulo) {
    $('#adminModal').modal("show");
    $("#btnModalGeneral").remove();
    var span = '';
    console.log('permissions',permissions)
    $.each(permissions, function(index, value) {
        span += ' <span class="right badge badge-primary mt-2">' + value.name + '</span>';
    });
    var spanEnd= span+"<br><br><button type='button' class='btn btn-danger text-white' data-dismiss='modal' id='closeModalGeneral' onclick='closeodalGeneral()'>Cerrar</button>";
    $("#modalTitle").html(titulo);
    $("#adminModalBody").html('');
    $("#adminModalBody").append(spanEnd);

}

function closeodalGeneral(){
    $('#adminModal').modal("hide");
}