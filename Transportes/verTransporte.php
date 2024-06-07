<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: index.html");
    exit;
}

include('bd.php');

$sql = "SELECT Transporte.*, Transportista.Empresa_Transp 
        FROM Transporte 
        INNER JOIN Transportista ON Transporte.ID_Transp = Transportista.ID_Transp";
$result = $conn->query($sql);

$transportes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transportes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Transportes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
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
    <h2 class="text-center">Lista de Transportes</h2>
    <table id="transportesTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Color</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Límite de Contenedores</th>
                <th>Peso Límite (kg)</th>
                <th>Empresa Transportista</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transportes as $transporte): ?>
                <tr>
                    <td><?php echo $transporte['Matricula']; ?></td>
                    <td><?php echo $transporte['Color_Transporte']; ?></td>
                    <td><?php echo $transporte['Tipo_Transporte']; ?></td>
                    <td><?php echo $transporte['Marca_Transporte']; ?></td>
                    <td><?php echo $transporte['Limite_Contenedores']; ?></td>
                    <td><?php echo $transporte['Peso_Limite']; ?></td>
                    <td><?php echo $transporte['Empresa_Transp']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transportesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    });
</script>
</body>
</html>
