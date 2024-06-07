<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $ubicacion = $_POST['ubicacion'];

    $sql = "INSERT INTO Cliente (Nombre_Cli, Telefono_Cli, Correo_Cli, Estado_Cli, Ubicacion_Cli) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("sssss", $nombre, $telefono, $correo, $estado, $ubicacion);
        
        if($stmt->execute()){
            echo "<script>alert('Cliente añadido exitosamente');</script>";
        } else {
            echo "<script>alert('Error al añadir el cliente');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Clientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="welcome.php">Sistema de Transportistas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="altasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Altas
                </a>
                <div class="dropdown-menu" aria-labelledby="altasDropdown">
                    <a class="dropdown-item" href="altaTransporte.php">Transportes</a>
                    <a class="dropdown-item" href="altaOperacion.php">Operacion</a>
                    <a class="dropdown-item" href="altaMercancia.php">Mercancia</a>
                    <a class="dropdown-item" href="altaCliente.php">Cliente</a>
                    <a class="dropdown-item" href="altaAduana.php">Aduana</a>
                    <a class="dropdown-item" href="altaImportador.php">Importador</a>
                    <a class="dropdown-item" href="altaTransportista.php">Transportista</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="solicitudesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Solicitudes
                </a>
                <div class="dropdown-menu" aria-labelledby="solicitudesDropdown">
                    <a class="dropdown-item" href="verSolicitudes.php">Ver Solicitudes</a>
                    <a class="dropdown-item" href="crearSolicitud.php">Crear Solicitud</a>
                    <a class="dropdown-item" href="asignarTransporte.php">Asignar Transportes</a>
                    <a class="dropdown-item" href="cambiarEstado.php">Cambiar Estado de Solicitudes</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="informacionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Información
                </a>
                <div class="dropdown-menu" aria-labelledby="informacionDropdown">
                    <a class="dropdown-item" href="verTransporte.php">Ver Transportes</a>
                    <a class="dropdown-item" href="verMercancia.php">Ver Mercancías</a>
                    <a class="dropdown-item" href="verCliente.php">Ver Clientes</a>
                    <a class="dropdown-item" href="verTransportista.php">Ver Transportistas</a>
                    <a class="dropdown-item" href="verImportador.php">Ver Importadores</a>
                    <a class="dropdown-item" href="verAduana.php">Ver Aduana</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Alta de Clientes</h2>
    <form method="post" action="altaCliente.php">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cliente" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{10}" placeholder="Teléfono del cliente" required>
            <small class="form-text text-muted">Debe ser un número de 10 dígitos.</small>
        </div>
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo del cliente" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado donde vive el cliente" required>
        </div>
        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicación del cliente" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
