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
    <?php
        $id_empleado_editar = $_GET['id'];
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
                        <h1 style="margin-bottom:2rem;" class="mt-4">Registro de Empleados</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Nuevo Empleado
                            </div>
                            <div class="card-body">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <span>✮ Validar Contraseña: </span></br>
                                        <span>-Mínimo 5 caracteres.</span></br>
                                        <span>-Mínimo un Número.</span>
                                    </div>
                                </div>
                                <div class="">
                                    
                                </div>
                                <?php
                                    //obtener los valores para editar
                                    $id_empleado_editar = $_GET['id'];
                                    $sql2 = "SELECT persona.ci, persona.correo,persona.edad,persona.nombre, persona.telefono, 
                                    persona.apellido_paterno, persona.apellido_materno,tipo_empleado.id_tipo_empleado,
                                    tipo_empleado.descripcion, empleado.estado, empleado.id_empleado, empleado.contrasena
                                    FROM persona 
                                    INNER JOIN empleado ON persona.id_persona = empleado.id_personaLF
                                    INNER JOIN tipo_empleado ON tipo_empleado.id_tipo_empleado = empleado.id_tipo_empleadoLF WHERE empleado.id_empleado = '$id_empleado_editar'";
                                    $resultado = $conexion -> query($sql2);
                                    if($resultado -> num_rows > 0){
                                        while($dataUsuario2 = $resultado -> fetch_assoc()){
                                            $nombreEdit = $dataUsuario2['nombre'];
                                            $apellido_paternoEdit = $dataUsuario2['apellido_paterno'];
                                            $apellido_maternoEdit = $dataUsuario2['apellido_materno'];
                                            $emailEdit = $dataUsuario2['correo'];
                                            $telefonoEdit = $dataUsuario2['telefono'];
                                            $ciEdit = $dataUsuario2['ci'];
                                            $contrasenaEdit = $dataUsuario2['contrasena'];
                                            $edadEdit = $dataUsuario2['edad'];  
                                            $id_tipoEmpleadoLF_Edit = $dataUsuario2['id_tipo_empleado'];
                                        }
                                    }
                                ?>
                                <div class="formularioAdd">
                                    <form id="formularioUsuario" class="needs-validation" novalidate onsubmit="editarEmpleado(event)" >
                                        <div class="form-row">
                                            <div style="display:none;" class="form-group col-md-6">
                                                <label for="inputID">id_usuario</label>
                                                <input type="text" class="form-control inputUser" id="inputID" placeholder="Nombre" required value="<?php echo $id_empleado_editar; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputName">Nombre</label>
                                                <input type="text" class="form-control inputUser" id="inputName" placeholder="Nombre" required value="<?php echo $nombreEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa un nombre válido.</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputCi">N° Cedula</label>
                                                <input type="number" class="form-control inputUser" id="inputCi" placeholder="Ci" required value="<?php echo $ciEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa un número de cédula válido.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputApellido1">Apellido Paterno</label>
                                                <input type="text" class="form-control inputUser" id="inputApellido1" placeholder="Apellido Paterno" required value="<?php echo $apellido_paternoEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa un apellido paterno válido.</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputApellido2">Apellido Materno</label>
                                                <input type="text" class="form-control inputUser" id="inputApellido2" placeholder="Apellido Materno" required value="<?php echo $apellido_maternoEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa un apellido materno válido.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" class="form-control inputUser" id="inputEmail4" placeholder="Email" required value="<?php echo $emailEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa un email válido.</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Contraseña</label>
                                                <input type="password" class="form-control inputUser" id="inputPassword4" placeholder="Contraseña" required value="<?php echo $contrasenaEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa una contraseña válida.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputTelefono">Telefono</label>
                                                <input type="number" class="form-control inputUser" id="inputTelefono" placeholder="Telefono" required value="<?php echo $telefonoEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa un número de teléfono válido.</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEdad">Edad</label>
                                                <input type="number" class="form-control inputUser" id="inputEdad" placeholder="Edad" required value="<?php echo $edadEdit; ?>">
                                                <div class="invalid-feedback">Por favor ingresa una edad válida.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputTipo">Tipo de Empleado</label>

                                                <?php
                                                    // Conexión a la base de datos
                                                    include_once '../../../billarApi/database/conexion.php';

                                                    // Obtener los datos de la tabla tipo_empleado
                                                    $query = "SELECT id_tipo_empleado, descripcion FROM tipo_empleado";
                                                    $resultado = mysqli_query($conexion, $query);

                                                    // Generar las opciones del select
                                                    echo "<select id='inputTipo' class='form-control inputUser'>";
                                                    echo "<option value='' disabled selected hidden>Elegir Tipo de Empleado</option>";
                                                    while ($row = mysqli_fetch_assoc($resultado)) {
                                                        $idEmpleado = $row['id_tipo_empleado'];
                                                        $descripcion = $row['descripcion'];
                                                    
                                                        // Chequear si el id actual es el mismo que el id seleccionado
                                                        if($idEmpleado == $id_tipoEmpleadoLF_Edit) {
                                                            echo "<option value='$idEmpleado' selected>$descripcion</option>";
                                                        } else {
                                                            echo "<option value='$idEmpleado'>$descripcion</option>";
                                                        }
                                                    }
                                                    echo "</select>";

                                                    // Cerrar la conexión a la base de datos
                                                    mysqli_close($conexion);
                                                ?>
                                                <div class="invalid-feedback">Escoja una opción válida</div>

                                            </div>  
                                        </div>
                                        <div style="display:flex;flex-direction:row;margin-top:2.5rem;" class="">
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                            <a href="../empleado.php" style="margin-left:2rem;" class="btn btn-dark">Cancelar</a>
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

    </body>
</html>

<?php
}else{
    header("Location:login.html");
}

?>