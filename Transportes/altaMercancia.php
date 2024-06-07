<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: index.html");
    exit;
}

include('bd.php');

$sql_tipo_mercancia = "SELECT ID_TipoM, TipoM FROM TipoMercancia";
$result_tipo_mercancia = $conn->query($sql_tipo_mercancia);

function fetch_data($result) {
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

$tipos_mercancia = fetch_data($result_tipo_mercancia);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_merc = $_POST['nombre_merc'];
    $marca_merc = $_POST['marca_merc'];
    $peso_merc = $_POST['peso_merc'];
    $volumen_merc = $_POST['volumen_merc'];
    $dimensiones_merc = $_POST['dimensiones_merc'];
    $id_tipo_merc = $_POST['id_tipo_merc'];

    $sql = "INSERT INTO Mercancia (Nombre_Merc, Marca_Merc, Peso_Merc, Volumen_Merc, Dimensiones_Merc, ID_TipoM) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssddsi", $nombre_merc, $marca_merc, $peso_merc, $volumen_merc, $dimensiones_merc, $id_tipo_merc);

        if ($stmt->execute()) {
            echo "<script>alert('Mercancía añadida exitosamente');</script>";
        } else {
            echo "<script>alert('Error al añadir la mercancía');</script>";
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
    <title>Alta de Mercancía</title>
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
    <h2 class="text-center">Alta de Mercancía</h2>
    <form method="post" action="altaMercancia.php">
        <div class="form-group">
            <label for="nombre_merc">Nombre de la Mercancía</label>
            <input type="text" class="form-control" id="nombre_merc" name="nombre_merc" placeholder="Nombre de la mercancía" required>
        </div>
        <div class="form-group">
            <label for="marca_merc">Marca de la Mercancía</label>
            <input type="text" class="form-control" id="marca_merc" name="marca_merc" placeholder="Marca de la mercancía" required>
        </div>
        <div class="form-group">
            <label for="peso_merc">Peso de la Mercancía (kg)</label>
            <input type="number" step="0.01" class="form-control" id="peso_merc" name="peso_merc" placeholder="Peso de la mercancía" required>
        </div>
        <div class="form-group">
            <label for="volumen_merc">Volumen de la Mercancía (m³)</label>
            <input type="number" step="0.01" class="form-control" id="volumen_merc" name="volumen_merc" placeholder="Volumen de la mercancía" required>
        </div>
        <div class="form-group">
            <label for="dimensiones_merc">Dimensiones de la Mercancía (cm)</label>
            <input type="text" class="form-control" id="dimensiones_merc" name="dimensiones_merc" placeholder="Dimensiones de la mercancía" required>
        </div>
        <div class="form-group">
            <label for="id_tipo_merc">Tipo de Mercancía</label>
            <select class="form-control" id="id_tipo_merc" name="id_tipo_merc" required>
                <?php foreach ($tipos_mercancia as $tipo): ?>
                    <option value="<?php echo $tipo['ID_TipoM']; ?>"><?php echo $tipo['TipoM']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
