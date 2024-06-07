<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: index.html");
    exit;
}

include('bd.php');

$sql_importadores = "SELECT ID_Imp, Empresa_Imp FROM Importador";
$result_importadores = $conn->query($sql_importadores);

$sql_clientes = "SELECT ID_Cli, Nombre_Cli FROM Cliente";
$result_clientes = $conn->query($sql_clientes);

$sql_aduanas = "SELECT ID_Ad, Estado_Ad FROM Aduana";
$result_aduanas = $conn->query($sql_aduanas);

$sql_mercancias = "SELECT ID_Merc, Nombre_Merc FROM Mercancia";
$result_mercancias = $conn->query($sql_mercancias);

$sql_pagos = "SELECT ID_Pago, Pago FROM TipoPago";
$result_pagos = $conn->query($sql_pagos);

function fetch_data($result) {
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

$importadores = fetch_data($result_importadores);
$clientes = fetch_data($result_clientes);
$aduanas = fetch_data($result_aduanas);
$mercancias = fetch_data($result_mercancias);
$pagos = fetch_data($result_pagos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $referencia = $_POST['referencia'];
    $pedimento = $_POST['pedimento'];
    $id_imp = $_POST['id_imp'];
    $id_cli = $_POST['id_cli'];
    $id_ad = $_POST['id_ad'];
    $fecha_salida = $_POST['fecha_salida'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $id_merc = $_POST['id_merc'];
    $id_pago = $_POST['id_pago'];

    $sql = "INSERT INTO Operacion (Referencia, Pedimento, ID_Imp, ID_Cli, ID_Ad, Fecha_Salida, Fecha_Entrega, ID_Merc, ID_Pago) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssiiissii", $referencia, $pedimento, $id_imp, $id_cli, $id_ad, $fecha_salida, $fecha_entrega, $id_merc, $id_pago);
        
        if ($stmt->execute()) {
            echo "<script>alert('Operación añadida exitosamente');</script>";
        } else {
            echo "<script>alert('Error al añadir la operación');</script>";
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
    <title>Alta de Operación</title>
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
    <h2 class="text-center">Alta de Operación</h2>
    <form method="post" action="altaOperacion.php">
        <div class="form-group">
            <label for="referencia">Referencia</label>
            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Número de referencia" required>
        </div>
        <div class="form-group">
            <label for="pedimento">Pedimento</label>
            <input type="text" class="form-control" id="pedimento" name="pedimento" placeholder="Número de pedimento" required>
        </div>
        <div class="form-group">
            <label for="id_imp">Importador</label>
            <select class="form-control" id="id_imp" name="id_imp" required>
                <?php foreach ($importadores as $importador): ?>
                    <option value="<?php echo $importador['ID_Imp']; ?>"><?php echo $importador['Empresa_Imp']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_cli">Cliente</label>
            <select class="form-control" id="id_cli" name="id_cli" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['ID_Cli']; ?>"><?php echo $cliente['Nombre_Cli']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_ad">Aduana</label>
            <select class="form-control" id="id_ad" name="id_ad" required>
                <?php foreach ($aduanas as $aduana): ?>
                    <option value="<?php echo $aduana['ID_Ad']; ?>"><?php echo $aduana['Estado_Ad']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_salida">Fecha de Salida</label>
            <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
        </div>
        <div class="form-group">
            <label for="fecha_entrega">Fecha de Entrega</label>
            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
        </div>
        <div class="form-group">
            <label for="id_merc">Mercancía</label>
            <select class="form-control" id="id_merc" name="id_merc" required>
                <?php foreach ($mercancias as $mercancia): ?>
                    <option value="<?php echo $mercancia['ID_Merc']; ?>"><?php echo $mercancia['Nombre_Merc']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_pago">Tipo de Pago</label>
            <select class="form-control" id="id_pago" name="id_pago" required>
                <?php foreach ($pagos as $pago): ?>
                    <option value="<?php echo $pago['ID_Pago']; ?>"><?php echo $pago['Pago']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Operación</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
