<?php
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: index.html");
    exit;
}

include('bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_solicitud']) && isset($_POST['matriculas'])) {
        $id_solicitud = $_POST['id_solicitud'];
        $matriculas = $_POST['matriculas'];

        $stmt_respuesta = $conn->prepare("INSERT INTO Respuesta (ID_Solicitud, Matricula) VALUES (?, ?)");
        $stmt_respuesta->bind_param("is", $id_solicitud, $matricula);

        foreach ($matriculas as $matricula) {
            $stmt_respuesta->execute();
        }

        $stmt_estado = $conn->prepare("UPDATE Solicitud SET ID_Estado = 3 WHERE ID_Solicitud = ?");
        $stmt_estado->bind_param("i", $id_solicitud);
        $stmt_estado->execute();

        header("location: cambiarEstado.php");
        exit;
    } else {
        echo "Error: ID de solicitud o matrículas no proporcionadas.";
    }
} else {
    echo "Acceso no permitido.";
}
$conn->close();
?>
