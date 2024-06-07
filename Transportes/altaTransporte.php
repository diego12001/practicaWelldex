<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

$sql_transportistas = "SELECT ID_Transp, Empresa_Transp FROM Transportista";
$result_transportistas = $conn->query($sql_transportistas);

$empresas_transportistas = [];
if ($result_transportistas->num_rows > 0) {
    while($row = $result_transportistas->fetch_assoc()) {
        $empresas_transportistas[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $color = $_POST['color'];
    $tipo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $limite_contenedores = $_POST['limite_contenedores'];
    $peso_limite = $_POST['peso_limite'];
    $id_transp = $_POST['id_transp'];

    $sql = "INSERT INTO Transporte (Matricula, Color_Transporte, Tipo_Transporte, Marca_Transporte, Limite_Contenedores, Peso_Limite, ID_Transp) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("ssssidi", $matricula, $color, $tipo, $marca, $limite_contenedores, $peso_limite, $id_transp);
        
        if($stmt->execute()){
            echo "<script>alert('Transporte añadido exitosamente');</script>";
        } else {
            echo "<script>alert('Error al añadir el transporte');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Transporte</title>
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
    <h2 class="text-center">Alta de Transporte</h2>
    <form method="post" action="altaTransporte.php">
        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matricula del transporte" required>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" class="form-control" id="color" name="color" placeholder="Color del transporte" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo de transporte" required>
        </div>
        <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca del transporte" required>
        </div>
        <div class="form-group">
            <label for="limite_contenedores">Límite de Contenedores</label>
            <select class="form-control" id="limite_contenedores" name="limite_contenedores" required>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div class="form-group">
            <label for="peso_limite">Peso Límite (kg)</label>
            <input type="number" step="0.01" class="form-control" id="peso_limite" name="peso_limite" placeholder="Peso límite en kg" required>
        </div>
        <div class="form-group">
            <label for="id_transp">Empresa Transportista</label>
            <select class="form-control" id="id_transp" name="id_transp" required>
                <?php foreach ($empresas_transportistas as $empresa): ?>
                    <option value="<?php echo $empresa['ID_Transp']; ?>"><?php echo $empresa['Empresa_Transp']; ?></option>
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
