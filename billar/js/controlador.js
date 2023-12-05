function loguear(event){
    event.preventDefault();

    var email = document.getElementById('email').value;
    var contrasena = document.getElementById('contrasena').value;

    var correo = email;

    var login = {
        correo,
        contrasena
    }

    axios({
        method:'POST',
        url:'../../billarApi/api/loginApi.php',
        responseType:'json',
        data:login
        
    }).then(res=>{
        console.log(res);
        if(res.data.succes==true){
            window.location.href="inicio.php";

        }else if(res.data.succes==false){
            texto = "Usuario y/o Contraseña Incorrecto(s)";
            MensajeError(texto);
        }
    }).catch(error=>{
        console.error(error);
    });


    console.log(email);
    console.log(contrasena);
}
//----------------------MENSAJES TOASTR-------------------------------------------

function MensajeError(texto){
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: texto,
        showConfirmButton: false,
        timer: 2000
    })
}

function MensajeCorrecto(texto){
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: texto,
        showConfirmButton: false,
        timer: 2000
    })
}
//---------------------------------Empleado--------------------------------------
function cargarEmpleados() {
    $.ajax({
        url: "../function/obtener_empleados.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar los empleados.");
        }
    });
}

function eliminarEmpleado(id) {
    console.log("ID del empleado a eliminar: " + id);
    id_empleado = id;
    if(id == 0){
        Swal.fire(
            'Error',
            'No es posible deshabilitar al administrador',
            'error'
        )
    }else{
        Swal.fire({
            title: 'Actualizar Estado Del Empleado',
            text: "Desea cambiar el estado del cliente?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, seguro',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.isConfirmed) {
            var empleado ={
                id_empleado
            }
            axios({
                method:'DELETE',
                url:'../../billarApi/api/empleadoApi.php',
                responseType:'json',
                data:empleado
                
            }).then(res=>{
                console.log(res);
                if(res.data.succes==true){
                    cargarEmpleados()
                    texto = 'Los datos se actualizaron'
                    MensajeCorrecto(texto)
        
                }else if(res.data.succes==false){
                    texto = "Error, problemas de base de datos";
                    MensajeError(texto);
                }
            }).catch(error=>{
                console.error(error);
            });

            };
        });
    }
}


function guardarEmpleado(event) {
    event.preventDefault();
    // Obtener los valores de los campos de entrada
    var nombre = document.getElementById("inputName").value;
    var ci = document.getElementById("inputCi").value;
    var apellido_paterno = document.getElementById("inputApellido1").value;
    var apellido_materno = document.getElementById("inputApellido2").value;
    var email = document.getElementById("inputEmail4").value;
    var contrasena = document.getElementById("inputPassword4").value;
    var telefono = document.getElementById("inputTelefono").value;
    var edad = document.getElementById("inputEdad").value;
    var id_tipoEmpleadoLF = document.getElementById("inputTipo").value;

    console.log("Nombre:", nombre);
    console.log("CI:", ci);
    console.log("Apellido Paterno:", apellido_paterno);
    console.log("Apellido Materno:", apellido_materno);
    console.log("Email:", email);
    console.log("Contraseña:", contrasena);
    console.log("Teléfono:", telefono);
    console.log("Edad:", edad);
    console.log("ID Tipo de Empleado:", id_tipoEmpleadoLF);

    var usuario = {
        ci, 
        nombre, 
        apellido_paterno, 
        apellido_materno, 
        email, 
        contrasena, 
        telefono, 
        edad, 
        id_tipoEmpleadoLF
    }
    
    var cantidadPass = contrasena.length;

    if (nombre === '' || ci === '' || apellido_paterno === '' || apellido_materno === '' || email === '' || contrasena === '' || telefono === '' || edad === '' || id_tipoEmpleadoLF === '') {
        var texto = "Completar campos vacíos";
        MensajeError(texto);
    } else if (edad < 18 || edad > 70) {
        var texto = "La edad establecida debe estar entre 18 y 70 años";
        MensajeError(texto);
    }else if(cantidadPass < 5 ){
        var texto = "La contraseña debe tener minimo 5 caracteres y una numero";
        MensajeError(texto);
    }
    else if (cantidadPass < 5 || !/\d/.test(contrasena)) {
        var texto = "La contraseña debe tener al menos 5 caracteres y contener al menos un número";
        MensajeError(texto);
    }    
    else if (!validarEmail(email)) {
        var texto = "El correo electrónico no es válido";
        MensajeError(texto);
    } else {
        axios({
            method:'POST',
            url:'../../../billarApi/api/empleadoApi.php',
            responseType:'json',
            data:usuario
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../empleado.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi'){
                texto = "Cedula de identidad se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorEmail'){
                texto = "Email se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi&Email'){
                texto = "Cedula de identidad y Email se encuentran registrados";
                MensajeError(texto);

            }
        }).catch(error=>{
            console.error(error);
        });
        
    }
}

function editarEmpleado(event) {
    event.preventDefault();
    // Obtener los valores de los campos de entrada
    var id_empleado = document.getElementById("inputID").value;
    var nombre = document.getElementById("inputName").value;
    var ci = document.getElementById("inputCi").value;
    var apellido_paterno = document.getElementById("inputApellido1").value;
    var apellido_materno = document.getElementById("inputApellido2").value;
    var email = document.getElementById("inputEmail4").value;
    var contrasena = document.getElementById("inputPassword4").value;
    var telefono = document.getElementById("inputTelefono").value;
    var edad = document.getElementById("inputEdad").value;
    var id_tipoEmpleadoLF = document.getElementById("inputTipo").value;

    console.log("Nombre:", nombre);
    console.log("CI:", ci);
    console.log("Apellido Paterno:", apellido_paterno);
    console.log("Apellido Materno:", apellido_materno);
    console.log("Email:", email);
    console.log("Contraseña:", contrasena);
    console.log("Teléfono:", telefono);
    console.log("Edad:", edad);
    console.log("ID Tipo de Empleado:", id_tipoEmpleadoLF);

    var empleado = {
        id_empleado,
        ci, 
        nombre, 
        apellido_paterno, 
        apellido_materno, 
        email, 
        contrasena, 
        telefono, 
        edad, 
        id_tipoEmpleadoLF
    }
    
    var cantidadPass = contrasena.length;

    if (nombre === '' || ci === '' || apellido_paterno === '' || apellido_materno === '' || email === '' || contrasena === '' || telefono === '' || edad === '' || id_tipoEmpleadoLF === '') {
        var texto = "Completar campos vacíos";
        MensajeError(texto);
    } else if (edad < 18 || edad > 70) {
        var texto = "La edad establecida debe estar entre 18 y 70 años";
        MensajeError(texto);
    }else if(cantidadPass < 5 ){
        var texto = "La contraseña debe tener minimo 5 caracteres y una numero";
        MensajeError(texto);
    }
    else if (cantidadPass < 5 || !/\d/.test(contrasena)) {
        var texto = "La contraseña debe tener al menos 5 caracteres y contener al menos un número";
        MensajeError(texto);
    }    
    else if (!validarEmail(email)) {
        var texto = "El correo electrónico no es válido";
        MensajeError(texto);
    } else {
        axios({
            method:'PUT',
            url:'../../../billarApi/api/empleadoApi.php',
            responseType:'json',
            data:empleado
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../empleado.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi'){
                texto = "Cedula de identidad se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorEmail'){
                texto = "Email se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi&Email'){
                texto = "Cedula de identidad y Email se encuentran registrados";
                MensajeError(texto);

            }
        }).catch(error=>{
            console.error(error);
        });
    }
}


function validarEmail(email) {
    // Expresión regular para validar el formato del correo electrónico
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

//---------------------------------------------------Clientes-----------------------------------------------------------------

function cargarClientes() {
    $.ajax({
        url: "../function/obtener_clientes.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar los clientes.");
        }
    });
}

function eliminarCliente(id){
    console.log("ID del usuario a eliminar: " + id);
    id_cliente = id;
    Swal.fire({
        title: 'Eliminar Cliente',
        text: "Desea eliminar el cliente?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        var cliente ={
            id_cliente
        }
        axios({
            method:'DELETE',
            url:'../../billarApi/api/clienteApi.php',
            responseType:'json',
            data:cliente
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarClientes()
                texto = 'Se eliminó el cliente'
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes == "errorReserva"){
                texto = "El cliente tiene registros en reservas";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });
    
}

function guardarCliente(event){
    event.preventDefault();

    // Obtener los valores de los campos de entrada
    var nombre = document.getElementById("inputName").value;
    var ci = document.getElementById("inputCi").value;
    var apellido_paterno = document.getElementById("inputApellido1").value;
    var apellido_materno = document.getElementById("inputApellido2").value;
    var correo = document.getElementById("inputEmail4").value;
    var telefono = document.getElementById("inputTelefono").value;
    var edad = document.getElementById("inputEdad").value;


    console.log("Nombre:", nombre);
    console.log("CI:", ci);
    console.log("Apellido Paterno:", apellido_paterno);
    console.log("Apellido Materno:", apellido_materno);
    console.log("Email:", correo);
    console.log("Teléfono:", telefono);
    console.log("Edad:", edad);


    var cliente = {
        ci, 
        nombre, 
        apellido_paterno, 
        apellido_materno, 
        correo, 
        telefono, 
        edad, 

    }
    

    if (nombre === '' || ci === '' || apellido_paterno === '' || apellido_materno === '' || correo === '' || telefono === '' || edad === '') {
        var texto = "Completar campos vacíos";
        MensajeError(texto);
    } else if (edad < 18 || edad > 70) {
        var texto = "La edad establecida debe estar entre 18 y 70 años";
        MensajeError(texto);
    }  
    else if (!validarEmail(correo)) {
        var texto = "El correo electrónico no es válido";
        MensajeError(texto);
    } else {
        axios({
            method:'POST',
            url:'../../../billarApi/api/clienteApi.php',
            responseType:'json',
            data:cliente
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../cliente.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi'){
                texto = "Cedula de identidad se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorEmail'){
                texto = "Email se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi&Email'){
                texto = "Cedula de identidad y Email se encuentran registrados";
                MensajeError(texto);

            }
        }).catch(error=>{
            console.error(error);
        });
        
    }
}

function editarCliente(event){
    event.preventDefault();

    // Obtener los valores de los campos de entrada
    var id_cliente = document.getElementById("inputID").value;
    var nombre = document.getElementById("inputName").value;
    var ci = document.getElementById("inputCi").value;
    var apellido_paterno = document.getElementById("inputApellido1").value;
    var apellido_materno = document.getElementById("inputApellido2").value;
    var correo = document.getElementById("inputEmail4").value;
    var telefono = document.getElementById("inputTelefono").value;
    var edad = document.getElementById("inputEdad").value;

    console.log("Nombre:", nombre);
    console.log("CI:", ci);
    console.log("Apellido Paterno:", apellido_paterno);
    console.log("Apellido Materno:", apellido_materno);
    console.log("Email:", correo);
    console.log("Teléfono:", telefono);
    console.log("Edad:", edad);


    var cliente = {
        id_cliente,
        ci, 
        nombre, 
        apellido_paterno, 
        apellido_materno, 
        correo, 
        telefono, 
        edad
    }
    

    if (nombre === '' || ci === '' || apellido_paterno === '' || apellido_materno === '' || correo === '' || telefono === '' || edad === '') {
        var texto = "Completar campos vacíos";
        MensajeError(texto);
    } else if (edad < 18 || edad > 70) {
        var texto = "La edad establecida debe estar entre 18 y 70 años";
        MensajeError(texto);
    }  
    else if (!validarEmail(correo)) {
        var texto = "El correo electrónico no es válido";
        MensajeError(texto);
    } else {
        axios({
            method:'PUT',
            url:'../../../billarApi/api/clienteApi.php',
            responseType:'json',
            data:cliente
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../cliente.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi'){
                texto = "Cedula de identidad se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorEmail'){
                texto = "Email se encuentra registrado";
                MensajeError(texto);
            }else if(res.data.succes=='errorCi&Email'){
                texto = "Cedula de identidad y Email se encuentran registrados";
                MensajeError(texto);

            }
        }).catch(error=>{
            console.error(error);
        });
    }

}

//-----------------------------------------------------------------------------------MESAS---------------------------------------------------------------------------------

function cargarMesas() {
    $.ajax({
        url: "../function/obtener_mesas.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar las mesas.");
        }
    });
}
function eliminarMesa(id){
    console.log("ID de la mesa a eliminar: " + id);
    id_mesa = id;
    Swal.fire({
        title: 'Actualizar Estado de la mesa',
        text: "Desea actualizar el estado de la mesa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        var mesa ={
            id_mesa
        }
        axios({
            method:'DELETE',
            url:'../../billarApi/api/mesaApi.php',
            responseType:'json',
            data:mesa
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarMesas()
                texto = 'Se actualizo el estado de la mesa';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });
}

function AgregarMesa(event){
    event.preventDefault();

    Swal.fire({
        title: 'Agregar Mesa de billar',
        text: "Desea agregar una nueva mesa de billar?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, agregar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        axios({
            method:'POST',
            url:'../../billarApi/api/mesaApi.php',
            responseType:'json',
            
            
        }).then(res=>{
            
        }).catch(error=>{
            console.error(error);
        });
        
        cargarMesas();
        texto = "Mesa agregada exitosamente";
        MensajeCorrecto(texto);

        };
    });


}

//--------------------------Reservas-------------------------------------------------------------

function cargarRerservas(){
    $.ajax({
        url: "../function/obtener_reservas.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar las mesas.");
        }
    });
}

function eliminarReserva(id){
    console.log("ID de la reserva a eliminar: " + id);
    id_reserva = id;
    Swal.fire({
        title: 'Cancelar Reserva',
        text: "Desea cancelar la reserva?, una vez cancelada ya no podrá restablecerla",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        var reserva ={
            id_reserva
        }
        axios({
            method:'DELETE',
            url:'../../billarApi/api/reservaApi.php',
            responseType:'json',
            data:reserva
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarRerservas()
                texto = 'Se ha cancelado la reserva';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });
}

function guardarReserva(event){
    event.preventDefault();

    var id_cliente =  document.getElementById("inputCliente").value;
    var id_mesa =  document.getElementById("inputMesa").value;
    var fecha_solicitud =  document.getElementById("inputFechaSolicitud").value;
    var fecha_alquiler =  document.getElementById("inputFechaAlquiler").value;
    var hora_start =  document.getElementById("inputHoraInicio").value;
    var hora_stop =  document.getElementById("inputHoraFin").value;
    var id_empleado =  document.getElementById("id_empleado").value;

    console.log("id_cliente: ", id_cliente);
    console.log("id_mesa: ", id_mesa);
    console.log("fecha_solicitud: ", fecha_solicitud);
    console.log("fecha_alquiler: ", fecha_alquiler);
    console.log("hora_start: ", hora_start);
    console.log("hora_stop: ", hora_stop);

    let reserva = {
        id_cliente,
        id_mesa,
        fecha_solicitud,
        fecha_alquiler,
        hora_start,
        hora_stop,
        id_empleado
    }
    if(fecha_alquiler == "" || hora_start == "" || hora_stop == ""){
        texto = "Completar Campos Vacios";
        MensajeError(texto);
    }else if(hora_start >= hora_stop){
        texto = "Configure las horas de la reserva";
        MensajeError(texto);
    }else if(fecha_solicitud > fecha_alquiler){
        texto = "Configure la fecha de alquiler";
        MensajeError(texto);
    }else{
        axios({
            method:'POST',
            url:'../../../billarApi/api/reservaApi.php',
            responseType:'json',
            data:reserva
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../reserva.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=="errorSolapamiento"){
                texto = "Ya existe una reserva con estos datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }
    
}

function completarReserva(id){
    var id_reserva = id;
    
    let reserva  = {
        id_reserva
    }
    Swal.fire({
        title: 'Reserva Completada',
        text: "Desea concluir totalmente con la reserva?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        axios({
            method:'PATCH',
            url:'../../billarApi/api/reservaApi.php',
            responseType:'json',
            data:reserva
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarRerservas()
                texto = 'Reserva Concluida';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });

}

function enProceso(id){
    var id_reserva = id;
    console.log(id_reserva);
    
    let reserva  = {
        id_reserva
    }
    Swal.fire({
        title: 'Estado en proceso?',
        text: "Desea poner en proceso el uso de la reserva?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        axios({
            method:'PATCH',
            url:'../../billarApi/api/reservaApi.php',
            responseType:'json',
            data:reserva
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarRerservas()
                texto = 'Reserva en Proceso!!';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });

}

function editarReserva(event){
    event.preventDefault();

    var id_reserva =  document.getElementById("id_reserva").value;
    var id_cliente =  document.getElementById("inputCliente").value;
    var id_mesa =  document.getElementById("inputMesa").value;
    var fecha_solicitud =  document.getElementById("inputFechaSolicitud").value;
    var fecha_alquiler =  document.getElementById("inputFechaAlquiler").value;
    var hora_start =  document.getElementById("inputHoraInicio").value;
    var hora_stop =  document.getElementById("inputHoraFin").value;
    

    console.log("id_reserva: ", id_reserva);
    console.log("id_cliente: ", id_cliente);
    console.log("id_mesa: ", id_mesa);
    console.log("fecha_solicitud: ", fecha_solicitud);
    console.log("fecha_alquiler: ", fecha_alquiler);
    console.log("hora_start: ", hora_start);
    console.log("hora_stop: ", hora_stop);

    let reserva = {
        id_reserva,
        id_cliente,
        id_mesa,
        fecha_solicitud,
        fecha_alquiler,
        hora_start,
        hora_stop,
    }
    if(fecha_alquiler == "" || hora_start == "" || hora_stop == ""){
        texto = "Completar Campos Vacios";
        MensajeError(texto);
    }else if(hora_start >= hora_stop){
        texto = "Configure las horas de la reserva";
        MensajeError(texto);
    }else if(fecha_solicitud > fecha_alquiler){
        texto = "Configure la fecha de alquiler";
        MensajeError(texto);
    }else{
        axios({
            method:'PUT',
            url:'../../../billarApi/api/reservaApi.php',
            responseType:'json',
            data:reserva
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                
                window.location.href="../reserva.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=="errorSolapamiento"){
                texto = "Ya existe una reserva con estos datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }
    
}

//-----------------------------------------------------PRODUCTOS-----------------------------------------------------------------------------------------------------
function cargarProductos(){
    $.ajax({
        url: "../function/obtener_productos.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar los productos.");
        }
    });
    
}

function guardarProducto(event){
    event.preventDefault();

    var nombre_producto =  document.getElementById("inputProducto").value;
    var id_marca =  document.getElementById("inputMarca").value;
    var id_tipo_producto =  document.getElementById("inputTipoProducto").value;
    var stock =  document.getElementById("inputCantidad").value;

    let producto = {
        nombre_producto,
        id_marca,
        id_tipo_producto,
        stock
    }

    if(nombre_producto == "" || stock == ""){
        texto = "Completar Campos vacios";
        MensajeError(texto);
    }else{
        axios({
            method:'POST',
            url:'../../../billarApi/api/productoApi.php',
            responseType:'json',
            data:producto
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../producto.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }
}

function eliminarProducto(id){
    var id_producto = id;
    console.log(id_producto);
    
    let producto  = {
        id_producto
    }
    Swal.fire({
        title: 'Eliminar Producto',
        text: "Desea eliminar el producto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        axios({
            method:'DELETE',
            url:'../../billarApi/api/productoApi.php',
            responseType:'json',
            data:producto
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarProductos()
                texto = 'Se eliminó el producto';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=="errorVenta"){
                texto = "Existen registro de ventas con este producto";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });
}

function editarProducto(event){
    event.preventDefault();

    var id_producto = document.getElementById("id_producto").value;
    var nombre_producto =  document.getElementById("inputProducto").value;
    var id_marca =  document.getElementById("inputMarca").value;
    var id_tipo_producto =  document.getElementById("inputTipoProducto").value;
    var stock =  document.getElementById("inputCantidad").value;

    let producto = {
        id_producto,
        nombre_producto,
        id_marca,
        id_tipo_producto,
        stock
    }

    if(nombre_producto == "" || stock == ""){
        texto = "Completar Campos vacios";
        MensajeError(texto);
    }else{
        axios({
            method:'PUT',
            url:'../../../billarApi/api/productoApi.php',
            responseType:'json',
            data:producto
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../producto.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }
}

//---------------------------------------------------Marcas--------------------------------------------------------------

function cargarMarcas(){
    $.ajax({
        url: "../function/obtener_marcas.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar los productos.");
        }
    });
}

function eliminarMarca(id){
    var id_marca = id;
    console.log(id_marca);
    
    let marca  = {
        id_marca
    }
    Swal.fire({
        title: 'Eliminar Marca',
        text: "Desea eliminar la marca?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        axios({
            method:'DELETE',
            url:'../../billarApi/api/marcaApi.php',
            responseType:'json',
            data:marca
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarMarcas()
                texto = 'Se eliminó la marca';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=="errorRegistro"){
                texto = "Existen registros con esta marca";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });
}

function guardarMarca(event){
    event.preventDefault();

    var nombre_marca = document.getElementById("inputMarca").value;
    console.log(nombre_marca);

    let marca = {
        nombre_marca
    }

    if(nombre_marca == ""){
        texto = "Completar Campos vacios";
        MensajeError(texto);
    }else{
        axios({
            method:'POST',
            url:'../../../billarApi/api/marcaApi.php',
            responseType:'json',
            data:marca
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../marca.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }
}

function editarMarca(event){
    event.preventDefault();

    var nombre_marca = document.getElementById("inputMarca").value;
    var id_marca = document.getElementById("id_marca").value;
    console.log(nombre_marca);

    let marca = {
        id_marca,
        nombre_marca
    }

    if(nombre_marca == ""){
        texto = "Completar Campos vacios";
        MensajeError(texto);
    }else{
        axios({
            method:'PUT',
            url:'../../../billarApi/api/marcaApi.php',
            responseType:'json',
            data:marca
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../marca.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }

}





///---------------------------------Categorias---------------------------------------------------------------------------

function cargarCategorias(){
    $.ajax({
        url: "../function/obtener_categorias.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            updateTable(data);
        },
        error: function() {
            alert("Error al cargar las categorias.");
        }
    });
}

function guardarCategoria(event){
    event.preventDefault();

    var descripcion = document.getElementById("inputCategoria").value;

    let categoria = {
        descripcion
    }

    if(descripcion == ""){
        texto = "Completar Campos vacios";
        MensajeError(texto);
    }else{
        axios({
            method:'POST',
            url:'../../../billarApi/api/categoriaApi.php',
            responseType:'json',
            data:categoria
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../categoria.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }

}

function eliminarCategoria(id){
    var id_categoria = id;
    console.log(id_categoria);
    
    let categoria  = {
        id_categoria
    }
    Swal.fire({
        title: 'Eliminar Categoria',
        text: "Desea eliminar la categoria?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, seguro',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        axios({
            method:'DELETE',
            url:'../../billarApi/api/categoriaApi.php',
            responseType:'json',
            data:categoria
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                cargarCategorias()
                texto = 'Se eliminó la categoria';
                MensajeCorrecto(texto)
    
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }else if(res.data.succes=="errorRegistro"){
                texto = "Existen registros con esta categoria";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });

        };
    });
}

function editarCategoria(event){
    event.preventDefault();

    var id_categoria = document.getElementById("id_categoria").value;
    var descripcion = document.getElementById("inputCategoria").value;

    let categoria = {
        id_categoria,
        descripcion
    }

    if(descripcion == ""){
        texto = "Completar Campos vacios";
        MensajeError(texto);
    }else{
        axios({
            method:'PUT',
            url:'../../../billarApi/api/categoriaApi.php',
            responseType:'json',
            data:categoria
            
        }).then(res=>{
            console.log(res);
            if(res.data.succes==true){
                window.location.href="../categoria.php";
            }else if(res.data.succes==false){
                texto = "Error, problemas de base de datos";
                MensajeError(texto);
            }
        }).catch(error=>{
            console.error(error);
        });
    }

}

//--------------------------------------------anadir consumo---------------------------------------------------------------



