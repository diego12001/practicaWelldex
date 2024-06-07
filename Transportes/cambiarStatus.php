<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_solicitud'])) {
    $idSolicitud = $_POST['id_solicitud'];

    $sqlEstadoActual = "SELECT ID_Estado FROM Solicitud WHERE ID_Solicitud = ?";
    $stmt = $conn->prepare($sqlEstadoActual);
    $stmt->bind_param("i", $idSolicitud);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $estadoActual = $row['ID_Estado'];

    if ($estadoActual < 9) {
        $nuevoEstado = $estadoActual + 1;
        $sqlActualizarEstado = "UPDATE Solicitud SET ID_Estado = ? WHERE ID_Solicitud = ?";
        $stmt = $conn->prepare($sqlActualizarEstado);
        $stmt->bind_param("ii", $nuevoEstado, $idSolicitud);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    }
} else {
    echo "invalid_request";
}

$conn->close();
?>
