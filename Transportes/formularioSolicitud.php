<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

if(isset($_GET['referencia'])) {
    $referencia = $_GET['referencia'];

    $sql_operacion = "SELECT * FROM Operacion WHERE Referencia = '$referencia'";
    $result_operacion = $conn->query($sql_operacion);

    if ($result_operacion->num_rows == 1) {
        $operacion = $result_operacion->fetch_assoc();

        $id_mercancia = $operacion['ID_Merc'];
        $sql_mercancia = "SELECT * FROM Mercancia WHERE ID_Merc = $id_mercancia";
        $result_mercancia = $conn->query($sql_mercancia);

        if ($result_mercancia->num_rows == 1) {
            $mercancia = $result_mercancia->fetch_assoc();
            $id_tipo_mercancia = $mercancia['ID_TipoM'];
            $sql_tipo_mercancia = "SELECT * FROM TipoMercancia WHERE ID_TipoM = $id_tipo_mercancia";
            $result_tipo_mercancia = $conn->query($sql_tipo_mercancia);

            if ($result_tipo_mercancia->num_rows == 1) {
                $tipo_mercancia = $result_tipo_mercancia->fetch_assoc();
                $tipo_carga = $tipo_mercancia['TipoM'];

                if ($tipo_carga == "Carga Suelta") {
                    $tipo_solicitud = "Carga Suelta";
                    $sql_transportistas = "SELECT * FROM Transportista";
                    $result_transportistas = $conn->query($sql_transportistas);

                } else {
                    $tipo_solicitud = "Contenedores";
                    $sql_tipos_contenedor = "SELECT * FROM TipoContenedor";
                    $result_tipos_contenedor = $conn->query($sql_tipos_contenedor);

                    $sql_transportistas = "SELECT * FROM Transportista";
                    $result_transportistas = $conn->query($sql_transportistas);
                }
            } else {
                echo "Error: No se pudo encontrar el tipo de mercancía.";
            }
        } else {
            echo "Error: No se pudo encontrar la mercancía asociada a la operación.";
        }
    } else {
        echo "Error: No se pudo encontrar la operación.";
    }
} else {
    echo "Error: No se proporcionó una referencia de operación.";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitud</title>
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
    <h2 class="text-center">Formulario de Solicitud</h2>
    <form action="procesarSolicitud.php" method="post">
        <input type="hidden" name="referencia" value="<?php echo htmlspecialchars($_GET['referencia']); ?>">
        <input type="hidden" name="id_estado" value="2">
        <div class="form-group">
            <label for="tipo_solicitud">Tipo de Solicitud</label>
            <input type="text" class="form-control" id="tipo_solicitud" value="<?php echo htmlspecialchars($tipo_solicitud); ?>" disabled>
        </div>
        <?php if($tipo_solicitud == "Contenedores"): ?>
            <div id="contenedor-group">
                <div class="form-group">
                    <label for="serie_contenedor">Serie del Contenedor</label>
                    <input type="text" class="form-control" name="serie_contenedor[]" required>
                </div>
                <div class="form-group">
                    <label for="id_tipo_contenedor">Tipo de Contenedor</label>
                    <select class="form-control" name="id_tipo_contenedor[]" required>
                        <?php while($row = $result_tipos_contenedor->fetch_assoc()): ?>
                            <option value="<?php echo $row['ID_TipoC']; ?>"><?php echo htmlspecialchars($row['Inicial_Cont']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="agregarContenedor()">Agregar Contenedor</button>
        <?php endif; ?>
        <div class="form-group">
            <label for="id_transp">Transportista</label>
            <select class="form-control" id="id_transp" name="id_transp" required>
                <?php while($row = $result_transportistas->fetch_assoc()): ?>
                    <option value="<?php echo $row['ID_Transp']; ?>"><?php echo htmlspecialchars($row['Empresa_Transp']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
    </form>
</div>

<script>
    function agregarContenedor() {
        var contenedorGroup = document.getElementById('contenedor-group');
        var nuevoContenedor = document.createElement('div');
        nuevoContenedor.classList.add('form-group');
        nuevoContenedor.innerHTML = `
            <label for="serie_contenedor">Serie del Contenedor</label>
            <input type="text" class="form-control" name="serie_contenedor[]" required>
            <label for="id_tipo_contenedor">Tipo de Contenedor</label>
            <select class="form-control" name="id_tipo_contenedor[]" required>
                <?php
                    $result_tipos_contenedor->data_seek(0);
                    while($row = $result_tipos_contenedor->fetch_assoc()):
                ?>
                <option value="<?php echo $row['ID_TipoC']; ?>"><?php echo htmlspecialchars($row['Inicial_Cont']); ?></option>
                <?php endwhile; ?>
            </select>
        `;
        contenedorGroup.appendChild(nuevoContenedor);
    }
</script>
</body>
</html>

