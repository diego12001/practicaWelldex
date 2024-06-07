<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

$sql = "SELECT S.ID_Solicitud, S.Referencia, M.Nombre_Merc AS Nombre_Mercancia, T.Empresa_Transp AS Transportista, E.Nombre_Estado AS Estado
        FROM Solicitud S
        JOIN Operacion O ON S.Referencia = O.Referencia
        JOIN Mercancia M ON O.ID_Merc = M.ID_Merc
        JOIN Transportista T ON S.ID_Transp = T.ID_Transp
        JOIN Estado E ON S.ID_Estado = E.ID_Estado
        WHERE S.ID_Estado >= 3 AND S.ID_Estado < 9;";

$result = $conn->query($sql);

$solicitudes = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $solicitudes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar estado a solicitudes</title>
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
        <h2 class="text-center">Cambiar estado de Solicitudes</h2>
        <table id="solicitudesTable" class="table">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Mercancia</th>
                    <th>Transportista</th>
                    <th>Estado</th>
                    <th>Cambiar Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($solicitudes as $solicitud): ?>
                    <tr>
                        <td><?php echo $solicitud['Referencia']; ?></td>
                        <td><?php echo $solicitud['Nombre_Mercancia']; ?></td>
                        <td><?php echo $solicitud['Transportista']; ?></td>
                        <td><?php echo $solicitud['Estado']; ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="cambiarEstado(<?php echo $solicitud['ID_Solicitud']; ?>)">Cambiar Estado</button>
                        </td>
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
            $('#solicitudesTable').DataTable();
        });

        function cambiarEstado(idSolicitud) {
            $.ajax({
                type: "POST",
                url: "cambiarStatus.php",
                data: { id_solicitud: idSolicitud },
                success: function(response) {
                    if (response === "success") {
                        alert("Estado cambiado correctamente");
                        location.reload();
                    }else if (response === "error") {
                        alert("Error al cambiar el estado");
                    } else {
                        alert("Respuesta inesperada del servidor");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Error al procesar la solicitud");
                }
            });
        }
    </script>
</body>
</html>

