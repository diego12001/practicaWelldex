<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: index.html");
    exit;
}

include('bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $referencia = $_POST['referencia'];
    $id_transp = $_POST['id_transp'];
    $id_estado = $_POST['id_estado'];

    $sql_solicitud = "INSERT INTO Solicitud (Referencia, ID_Transp, ID_Estado) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql_solicitud)) {
        $stmt->bind_param("sii", $referencia, $id_transp, $id_estado);
        if (!$stmt->execute()) {
            echo "<script>alert('Error al procesar la solicitud principal');</script>";
            exit;
        }
    } else {
        echo "<script>alert('Error en la preparación de la consulta de la solicitud principal');</script>";
        exit;
    }

    $id_solicitud = $stmt->insert_id;

    if (!empty($_POST['serie_contenedor']) && !empty($_POST['id_tipo_contenedor'])) {
        $serie_contenedores = $_POST['serie_contenedor'];
        $id_tipos_contenedor = $_POST['id_tipo_contenedor'];

        $sql_contenedor = "INSERT INTO ContenedoresSoli (ID_Solicitud, Serie_Contenedor, ID_TipoC) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql_contenedor)) {
            for ($i = 0; $i < count($serie_contenedores); $i++) {
                $stmt->bind_param("iss", $id_solicitud, $serie_contenedores[$i], $id_tipos_contenedor[$i]);
                if (!$stmt->execute()) {
                    echo "<script>alert('Error al procesar el contenedor');</script>";
                    exit;
                }
            }
        } else {
            echo "<script>alert('Error en la preparación de la consulta de contenedores');</script>";
            exit;
        }
    }

    echo "<script>alert('Solicitud procesada exitosamente');</script>";
    echo "<script>window.location.href = 'crearSolicitud.php';</script>";
    exit;
}

$conn->close();
?>
