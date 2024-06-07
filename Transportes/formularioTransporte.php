<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

if(isset($_GET['id_solicitud'])) {
    $id_solicitud = $_GET['id_solicitud'];

    $sql_solicitud = "SELECT Solicitud.Referencia, Transportista.ID_Transp, Transportista.Empresa_Transp
                      FROM Solicitud
                      INNER JOIN Transportista ON Solicitud.ID_Transp = Transportista.ID_Transp
                      WHERE ID_Solicitud = ?";
    
    if($stmt = $conn->prepare($sql_solicitud)) {
        $stmt->bind_param("i", $id_solicitud);
        $stmt->execute();
        $result_solicitud = $stmt->get_result();
        $solicitud_info = $result_solicitud->fetch_assoc();
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta para obtener información de la solicitud.";
    }

    $id_transportista = $solicitud_info['ID_Transp'];
    $sql_matriculas = "SELECT Matricula FROM Transporte WHERE ID_Transp = ?";
    
    if($stmt = $conn->prepare($sql_matriculas)) {
        $stmt->bind_param("i", $id_transportista);
        $stmt->execute();
        $result_matriculas = $stmt->get_result();
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta para obtener las matrículas asociadas a la transportista.";
    }
} else {
    echo "ID de solicitud no proporcionada.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Transporte</title>
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
        <div class="card">
            <h5 class="card-header">Asignar Transporte</h5>
            <div class="card-body">
                <h5 class="card-title">Referencia de la Solicitud: <?php echo $solicitud_info['Referencia']; ?></h5>
                <p class="card-text">Transportista: <?php echo $solicitud_info['Empresa_Transp']; ?></p>
                <form action="procesarTransporte.php" method="post">
                    <input type="hidden" name="id_solicitud" value="<?php echo $id_solicitud; ?>">
                    <div class="form-group">
                        <label for="matriculas">Matrículas Disponibles:</label>
                        <select class="form-control" id="matriculas" name="matriculas[]" multiple required>
                            <?php while($row = $result_matriculas->fetch_assoc()): ?>
                                <option value="<?php echo $row['Matricula']; ?>"><?php echo $row['Matricula']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Transporte</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
