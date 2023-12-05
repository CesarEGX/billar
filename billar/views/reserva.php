<?php
session_start();
//variables de retornos
$id_empleado = $_SESSION['id_empleado'];

if(($_SESSION["id_empleado"]) != ''){
    //conexion
    include_once '../../billarApi/database/conexion.php';

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Billar</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../styles/styles.css" rel="stylesheet" />
        <link href="../styles/layaout.css" rel="stylesheet" />
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <!--TOASTER-->
        <link href="../styles/sweetalert2.min.css" rel="stylesheet">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        
    </head>

    <?php
        //consulta
        $sql = "SELECT persona.nombre, persona.apellido_paterno, persona.apellido_materno 
        FROM persona 
        INNER JOIN empleado 
        ON persona.id_persona = empleado.id_personaLF WHERE empleado.id_empleado = '$id_empleado'";

        $resultado = $conexion -> query($sql);
        if($resultado -> num_rows > 0){
            while($dataUsuario = $resultado -> fetch_assoc()){
                $nombre = $dataUsuario['nombre'];
                $apellido_paterno = $dataUsuario['apellido_paterno'];
                $apellido_materno = $dataUsuario['apellido_materno'];
            }
        }
    ?>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Billar Springfield</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <span class="sesionUsuario"><?php echo $nombre.' '.$apellido_paterno.' '.$apellido_materno;?> </span>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li style="display:none;"><a class="dropdown-item" href="#!">Settings</a></li>
                        <li style="display:none;"><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li style="display:none;"><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../function/cerrar_sesion.php">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Escritorio</div>
                            <a class="nav-link" href="inicio.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Inicio
                            </a>
                            <div class="sb-sidenav-menu-heading">Personas</div>
                            <a class="nav-link" href="empleado.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                                Empleados
                            </a>
                            <a class="nav-link" href="cliente.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-users"></i></div>
                                Clientes
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">GESTIONAR</div>
                            <a class="nav-link" href="mesa.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Mesas
                            </a>
                            <a class="nav-link" href="reserva.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                                Reservas
                            </a>
                            <div class="sb-sidenav-menu-heading">Inventario</div>
                            <a class="nav-link" href="producto.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-dolly"></i></div>
                                Productos
                            </a>
                        </div>
                    </div>
                    <div style="display:none;" class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 style="margin-bottom:2rem;" class="mt-4">Registro de Reservas</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                Registros la reserva de un cliente
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabla de Reservas
                            </div>
                            <div class="card-body">
                                <div class="tblTop">
                                    <div>
                                        <label>Buscar:</label>
                                        <input id="buscador" class="buscar" type="text">
                                    </div>

                                    <div>
                                        <label>Fecha de Alquiler:</label>
                                        <input id="filtroFechaAlquiler" class="buscar" type="date">
                                        <button title="Filtrar Fecha" style="background-color:#D47D11;border-color:#D47D11;" type="submit" id="botonFiltrarFecha" class="btn btn-primary"><i class='fas fa-filter'></i></button>
                                        <a href="reserva.php" title="Retornar" id="botonRetornar" style="display: none; background-color:#3A94FF;border-color:#3A94FF;" class="btn btn-success"><i class='fa fa-rotate-left'></i></a>

                                    </div>
                                        
                                    <div>
                                        <a href="add/anadirReserva.php" class="btn btn-success">Nuevo</a>
                                    </div>
                                </div>

                                <div style="height:500px;overflow:auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="titulosTabla">
                                                <th style="text-align:center" scope="col">Cliente</th>
                                                <th style="text-align:center" scope="col">Fecha de Solicitud</th>
                                                <th style="text-align:center" scope="col">Fecha de Alquiler</th>
                                                <th style="text-align:center" scope="col">Hora a iniciar</th>
                                                <th style="text-align:center" scope="col">Hora a finalizar</th>
                                                <th style="text-align:center" scope="col">N° Mesa</th>
                                                <th style="text-align:center" scope="col">Estado</th>
                                                <th style="text-align:center" scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaClientes">
                                            <!-- Aquí se cargarán los datos de los usuarios con ajax -->
                                        </tbody>
                                    </table>
                                </div>   
                            </div>
                        </div>
                    </div>
                </main>

                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Nick Arias 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                cargarRerservas();
                
                // Agregar funcionalidad de búsqueda
                $("#buscador").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#tablaClientes tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

            function updateTable(data) {
                var tablaClientes = $("#tablaClientes");
                tablaClientes.empty();
                var rutaImagenes = "../img/"; 

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var reserva = data[i];

                        var fechaSolicitud = new Date(reserva.fecha_solicitud.replace(/-/g, '/'));
                        var fechaSolicitudFormateada = ("0" + fechaSolicitud.getDate()).slice(-2) + "/" + ("0" + (fechaSolicitud.getMonth() + 1)).slice(-2) + "/" + fechaSolicitud.getFullYear();

                        var fechaAlquiler = new Date(reserva.fecha_alquiler.replace(/-/g, '/'));
                        var fechaAlquilerFormateada = ("0" + fechaAlquiler.getDate()).slice(-2) + "/" + ("0" + (fechaAlquiler.getMonth() + 1)).slice(-2) + "/" + fechaAlquiler.getFullYear();
                        // Formato de hora: hora:minutos
                        var horaInicio = new Date();
                        horaInicio.setHours(reserva.hora_start.split(':')[0]);
                        horaInicio.setMinutes(reserva.hora_start.split(':')[1]);
                        var horaInicioFormateada = horaInicio.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        var horaFin = new Date();
                        horaFin.setHours(reserva.hora_stop.split(':')[0]);
                        horaFin.setMinutes(reserva.hora_stop.split(':')[1]);
                        var horaFinFormateada = horaFin.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });


                        var fila = "<tr>" +
                            "<td style='text-align:center'>" + reserva.nombre + " " + reserva.apellido_paterno + "</td>" +
                            "<td style='text-align:center'>" + fechaSolicitudFormateada + "</td>" +
                            "<td style='text-align:center'>" + fechaAlquilerFormateada + "</td>" +
                            "<td style='text-align:center'>" + horaInicioFormateada + "</td>" +
                            "<td style='text-align:center'>" + horaFinFormateada + "</td>" +
                            "<td style='text-align:center'>" + reserva.numero_mesa +  "</td>" +
                            "<td style='text-align:center'>" + 
                                (reserva.estado == 1 ? 'Reservado' : reserva.estado == 0 ? 'Cancelado' : reserva.estado == 2 ? 'En proceso' : 'Completado') + 
                            "</td>" +
                            "<td style='text-align:center'>" +
                            (reserva.estado == 1 ? '<button title="Cancelar" class=\'btn btn-danger\' style="margin-right:5px;" onclick=\'eliminarReserva(' + reserva.id_reserva + ')\'><i class=\'fas fa fa-trash\'></i></button>' : '') +
                            (reserva.estado == 1 ? "<a title='Editar' href='edit/editarReserva.php?id=" + reserva.id_reserva + "' class='btn btn-info'><i style='color:#fff;' class='fas fa fa-edit'></i></a>" : '') +
                            (reserva.estado == 2 ? '<button title="Completado" class=\'btn btn-success\' onclick=\'completarReserva(' + reserva.id_reserva + ')\'><i class=\'far fa-calendar-check fa-lg\'></i></button>' : '') + (reserva.estado == 1 ? '<button style="margin-left:5px;" title="En proceso" class=\'btn btn-warning\' style="margin-right:5px;" onclick=\'enProceso(' + reserva.id_reserva + ')\'><i style="color:white;" class=\'fas fa-clock fa-lg\'></i></button>' : '')  + (reserva.estado == 3 ? '<button class=\'btn btn-primary\'><i class=\'fas fa-shopping-cart\'></i></button>' : reserva.estado == 2 ?  '<button data-toggle="modal" style="margin-left:5px;" class=\'btn btn-primary\' onclick="abrirModal(' + reserva.id_reserva + ')"><i class=\'fas fa-shopping-cart\'></i></button>' : '') +
                            //inservible solo para dar espacio
                            (reserva.estado == 0 ? '<button style="visibility:hidden;" class=\'btn btn-primary\'><i class=\'fas fa-shopping-cart\'></i></button>' : '')
                            "</td>" +

                            "</tr>";
                        tablaClientes.append(fila);

                    }
                } else {
                    tablaClientes.append("<tr><td style='text-align:center' colspan='8'>No se encontraron reservas.</td></tr>");
                }
            }



        </script>

        <script>
            $("#botonFiltrarFecha").on("click", function() {
                var valorInput = $("#filtroFechaAlquiler").val();

                // Si el valor del input está vacío, termina la función de inmediato
                if (!valorInput) {
                    return;
                }

                // Muestra el botón "Retornar" cuando se presiona el botón "Filtrar Fecha"
                $("#botonRetornar").show();

                var fechaSeleccionada = new Date(valorInput);

                fechaSeleccionada.setMinutes(fechaSeleccionada.getMinutes() - fechaSeleccionada.getTimezoneOffset()); // Ajuste de la zona horaria
                fechaSeleccionada.setHours(0, 0, 0, 0);  // Establece la hora a medianoche para la comparación

                // Filtra las filas de la tabla
                $("#tablaClientes tr").filter(function() {
                    var fechaAlquilerCelda = $(this).find("td").eq(2).text();  // Consigue la fecha de alquiler de la fila

                    var partes = fechaAlquilerCelda.split("/");

                    var dia = parseInt(partes[0], 10);
                    var mes = parseInt(partes[1], 10) - 1; // Asegúrate de que los meses estén en el rango de 0-11
                    var anio = parseInt(partes[2], 10);

                    var fechaAlquiler = new Date(anio, mes, dia);
                    fechaAlquiler.setMinutes(fechaAlquiler.getMinutes() - fechaAlquiler.getTimezoneOffset()); // Ajuste de la zona horaria
                    fechaAlquiler.setHours(0, 0, 0, 0); // Establece la hora a medianoche para la comparación

                    $(this).toggle(+fechaAlquiler.getTime() === +fechaSeleccionada.getTime());  // Muestra la fila solo si las fechas coinciden
                });
            });




        </script>



        <!--Modal Adicionar No usado-->  
        <div class="modal fade" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content" style="width:50rem;position:relative;right:8rem;">
                <form id="addForm">
                    <div class="modal-header" style="background-color:#0d6efd">
                        <h4 class="modal-title" style="color:#fff;">Consumos</h4>
                        
                    </div>

                    <div style="display:flex;flex-direction:row; gap:10px;" class="modal-body">
                        <div class="form-group">
                            <label for="add_id_cuenta">Id reserva</label>
                            <input type="number" class="form-control" id="add_id_reserva" name="add_id_reserva" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="add_nombre_cuenta">Producto</label>
                            <input type="text" class="form-control" id="add_nombre_producto" name="add_nombre_producto" required>
                        </div>
                        <div class="form-group">
                            <label for="add_nombre_cuenta">Cantidad</label>
                            <input type="text" class="form-control" id="add_nombre_cantidad" name="add_nombre_cantidad" required>
                        </div>
                        <div class="form-group">
                            <label for="add_nombre_cuenta">Precio</label>
                            <input type="text" class="form-control" id="add_nombre_precio" name="add_nombre_precio" required>
                        </div>
                        <div class="form-group">
                            <button style="position:relative;top:1.5rem;margin-left:25px;" 
                            type="submit" class="btn btn-primary" id="btn-submit">Guardar</button> 
                        </div>
                    </div>
                    
                    
                </form>
                    <div>
                        <!--tabla-->
                        <div style="height:500px;overflow:auto;padding:1rem;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="titulosTabla">
                                        <th style="text-align:center" scope="col">Producto</th>
                                        <th style="text-align:center" scope="col">Cantidad</th>
                                        <th style="text-align:center" scope="col">Precio</th>
                                        <th style="text-align:center" scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaConsumos">

                                </tbody>
                            </table>
                        </div>   
                    </div>
                <div class="modal-footer">
                        <div class="cerrarMD">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModalAñadir()">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../vendor/chart.js/Chart.min.js"></script>
        <!--Script propios del dashboard-->
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
        
        <!-- Axios js-->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <!--Controlador-->
        <script src="../js/controlador.js"></script>
        <!--Toaster-->
        <script src="../js/sweetalert2.all.min.js"></script>
        

    </body>
</html>

<?php
}else{
    header("Location:login.html");
}

?>