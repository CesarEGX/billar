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
                        <h1 style="margin-bottom:2rem;" class="mt-4">Registro de Productos</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                Registra los productos para el consumo del cliente
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a style="text-decoration:underline;color:#212529" href="producto.php">Productos</a> / <a style="text-decoration:none;color:#212529" href="marca.php" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Marcas</a> / <a style="text-decoration:none;color:#212529" href="categoria.php" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Categorias</a>
                            </div>
                            <div class="card-body">
                                <div class="tblTop">
                                    <div>
                                        <label>Buscar:</label>
                                        <input id="buscador" class="buscar" type="text">
                                    </div>
                                    <div>
                                        <a href="add/anadirProducto.php" class="btn btn-success" >Nuevo</a>
                                    </div>
                                </div>

                                <div style="height:500px;overflow:auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="titulosTabla">
                                                <th style="text-align:center" scope="col">Producto</th>
                                                <th style="text-align:center" scope="col">Marca</th>
                                                <th style="text-align:center" scope="col">Categoria</th>
                                                <th style="text-align:center" scope="col">Stock</th>
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
                cargarProductos();
                
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

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var producto = data[i];
                        var fila = "<tr>" +
                            "<td style='text-align:center'>" + producto.nombre + "</td>" +
                            "<td style='text-align:center'>" + producto.nombre_marca + "</td>" +
                            "<td style='text-align:center'>" + producto.nombre_categoria + "</td>" +
                            "<td style='text-align:center'>" + producto.stock + "</td>" +
                            "<td style='text-align:center'>" + '<button class=\'btn btn-danger\' onclick=\'eliminarProducto(' + producto.id_producto + ')\'><i class=\'fas fa fa-trash\'></i></button>' + " <a href='edit/editarProducto.php?id=" + producto.id_producto + "' class='btn btn-info'><i style='color:#fff;' class='fas fa fa-edit'></i></a>" +
                            "</td>" +
                            "</tr>";
                        tablaClientes.append(fila);
                    }
                } else {
                    tablaClientes.append("<tr><td style='text-align:center' colspan='4'>No se encontraron productos.</td></tr>");
                }
            }



        </script>



        <!--Modal Adicionar No usado-->  
        <div class="modal fade" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <form id="addForm">
                    <div class="modal-header" style="background-color:#1cc88a">
                        <h4 class="modal-title" style="color:#fff;">Añadir Cuenta</h4>
                        
                    </div>
                    <div class="modal-body">
                    <div style="display:none;" class="form-group">
                        <label for="add_id_cuenta">Id cuenta</label>
                        <input type="number" class="form-control" id="add_id_cuenta" name="add_id_cuenta" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="add_nombre_cuenta">Nombre</label>
                        <input type="text" class="form-control" id="add_nombre_cuenta" name="add_nombre_cuenta" required>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <div class="cerrarMD">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="acciones">
                        <button style="background-color:#1cc88a; border:none;position:relative;left:5px;" 
                        type="submit" class="btn btn-primary" id="btn-submit">Guardar</button>           
                    </div>    
                    </div>
                </form>
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