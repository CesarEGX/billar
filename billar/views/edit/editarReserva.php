<?php
session_start();
//variables de retornos
$id_empleado = $_SESSION['id_empleado'];

if(($_SESSION["id_empleado"]) != ''){
    //conexion
    include_once '../../../billarApi/database/conexion.php';

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
        <link href="../../styles/styles.css" rel="stylesheet" />
        <link href="../../styles/layaout.css" rel="stylesheet" />
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <!--TOASTER-->
        <link href="../../styles/sweetalert2.min.css" rel="stylesheet">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="../../styles/validarFormulario2.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        
        
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

        //llegada de datos
        $id_reserva = $_GET['id'];
        $sql2 = "SELECT re.*,de.id_mesaLF, de.fecha_reserva, de.hora_start, de.hora_stop
            FROM reserva re 
            INNER JOIN detalle_mesa de ON re.id_reserva = de.id_reservaLF
            WHERE re.id_reserva = '$id_reserva'
        ";
        $resultado = $conexion -> query($sql2);
        if($resultado -> num_rows > 0){
            while($dataUsuario = $resultado -> fetch_assoc()){
                $fecha_solicitud = $dataUsuario['fecha_solicitud'];
                $fecha_alquiler = $dataUsuario['fecha_alquiler'];
                $id_clienteLF = $dataUsuario['id_clienteLF'];
                $id_mesaLF = $dataUsuario['id_mesaLF'];
                $hora_start = $dataUsuario['hora_start'];
                $hora_stop = $dataUsuario['hora_stop'];
            }
        }

        date_default_timezone_set('America/La_Paz');
        $fechaHoy = date('Y-m-d');
    ?>

    <style>
        .select2-container .select2-selection--single {
            height: 35px; /* Altura que desees */
            border: 1px solid #d1d3e2;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px; /* Altura que desees */
            
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px; /* Altura que desees */
        }

    </style>

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
                            <a class="nav-link" href="../inicio.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Inicio
                            </a>
                            <div class="sb-sidenav-menu-heading">Personas</div>
                            <a class="nav-link" href="../empleado.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                                Empleados
                            </a>
                            <a class="nav-link" href="../cliente.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-users"></i></div>
                                Clientes
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">GESTIONAR</div>
                            <a class="nav-link" href="../mesa.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Mesas
                            </a>
                            <a class="nav-link" href="../reserva.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                                Reservas
                            </a>
                            <div class="sb-sidenav-menu-heading">Inventario</div>
                            <a class="nav-link" href="../producto.php">
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
                        <h1 style="margin-bottom:2rem;" class="mt-4">Registro de reserva</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Nueva Reserva
                            </div>
                            <div class="card-body">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <span>✮ Recordatorio: </span></br>
                                        <span>-No se puede reservar en una fecha con reserva y mismo n° de mesa .</span></br>
                                    </div>
                                </div>
                                <div class="">
                                    
                                </div>
                                <div class="formularioAdd">
                                    <form id="formularioUsuario" class="needs-validation" novalidate onsubmit="editarReserva(event)" >
                                        <div class="form-row">
                                            <input type="hidden" id="id_reserva" value="<?php echo $id_reserva; ?>" >
                                            <div style="display:flex;flex-direction:column;margin-top:3px;" class="form-group col-md-6">
                                                <label for="inputName">Cliente</label>
                                                <?php
                                                    $sql = "SELECT cl.*,per.nombre,per.apellido_paterno,per.ci
                                                        FROM cliente cl
                                                        INNER JOIN persona per ON cl.id_personaLF = per.id_persona
                                                        ORDER BY cl.id_cliente DESC";

                                                    $resultado = mysqli_query($conexion,$sql);
                                                ?>
                                                <select class="form-control inputUser" id="inputCliente" required>

                                                    <?php
                                                        if($resultado -> num_rows > 0){
                                                            while($row = $resultado->fetch_assoc()){
                                                                $selected = $row["id_cliente"] == $id_clienteLF ? 'selected' : '';
                                                                echo "<option value='".$row["id_cliente"]."' ".$selected.">".$row["nombre"]." ".$row["apellido_paterno"]." /  Ci:".$row['ci']. "</option>";
                                                            }
                                                        }else{
                                                            echo "No se encontraron resultado";
                                                        }

                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Por favor ingrese un Cliente válido.</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputCi">N° de Mesa</label>
                                                <?php
                                                    $sql = "SELECT * FROM mesa WHERE estado = 1";
                                                    $resultado = mysqli_query($conexion,$sql);
                                                ?>

                                                <select class="form-control inputUser" id="inputMesa" required>
                                                    <?php
                                                        if($resultado -> num_rows > 0){
                                                            while($row = $resultado -> fetch_assoc()){
                                                                $selected = $row["id_mesa"] == $id_mesaLF ? 'selected' : '';
                                                                echo "<option value='".$row["id_mesa"]."' ".$selected.">".$row["numero_mesa"]."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Por favor ingresa un número de mesa válido.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputApellido1">Fecha de Solicitud</label>
                                                <input type="date" class="form-control inputUser" id="inputFechaSolicitud" value="<?php echo $fecha_solicitud; ?>" required readonly>
                                                <div class="invalid-feedback">Por favor ingresa una fecha válida.</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputApellido2">Fecha de Alquiler</label>
                                                <input type="date" class="form-control inputUser" id="inputFechaAlquiler" required value="<?php echo $fecha_alquiler; ?>">
                                                <div class="invalid-feedback">Por favor ingresa una fecha.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Hora a Iniciar</label>
                                                <input type="time" class="form-control inputUser" id="inputHoraInicio" required value="<?php echo $hora_start; ?>">
                                                <div class="invalid-feedback">Por favor ingresa una hora válida</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputTelefono">Hora a Finalizar</label>
                                                <input type="time" class="form-control inputUser" id="inputHoraFin" required value="<?php echo $hora_stop; ?>">
                                                <div class="invalid-feedback">Por favor ingresa una hora válida.</div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div style="display:flex;flex-direction:row;margin-top:2.5rem;" class="">
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                            <a href="../reserva.php" style="margin-left:2rem;" class="btn btn-dark">Cancelar</a>
                                        </div>
                                    </form>
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
                $('#inputCliente').select2();
            });
        </script>
        
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="../../vendor/chart.js/Chart.min.js"></script>
        <!--Script propios del dashboard-->
        <script src="../../js/scripts.js"></script>
        <!-- Axios js-->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../assets/demo/chart-area-demo.js"></script>
        <script src="../../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../../js/datatables-simple-demo.js"></script>
        <!--Validar formulario-->
        <script src="../../js/validarFormulario2.js"></script>
        <!--Controlador-->
        <script src="../../js/controlador.js"></script>
        <!--Toaster-->
        <script src="../../js/sweetalert2.all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    </body>
</html>

<?php
}else{
    header("Location:login.html");
}

?>