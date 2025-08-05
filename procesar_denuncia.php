<?php
// procesar_denuncia.php
require_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar que los campos requeridos no estén vacíos
    if (empty(trim($_POST["denuncia_texto"])) || empty(trim($_POST["tipo_denuncia"]))) {
        header("location: denuncias.php?status=empty");
        exit;
    }

    // Obtener los datos del formulario
    $tipo_denuncia = trim($_POST["tipo_denuncia"]);
    $denuncia_texto = trim($_POST["denuncia_texto"]);
    $contacto_opcional = !empty(trim($_POST["contacto_opcional"])) ? trim($_POST["contacto_opcional"]) : NULL;

    // Preparar la consulta SQL para insertar la denuncia (con el nuevo campo)
    $sql = "INSERT INTO denuncias (tipo_denuncia, denuncia_texto, contacto_opcional) VALUES (?, ?, ?)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Vincular los parámetros ('sss' = 3 strings)
        $stmt->bind_param("sss", $param_tipo, $param_texto, $param_contacto);

        // Establecer los valores de los parámetros
        $param_tipo = $tipo_denuncia;
        $param_texto = $denuncia_texto;
        $param_contacto = $contacto_opcional;

        if ($stmt->execute()) {
            header("location: denuncias.php?status=success");
        } else {
            header("location: denuncias.php?status=error");
        }
        $stmt->close();
    } else {
        header("location: denuncias.php?status=error");
    }
    $mysqli->close();
    exit;
} else {
    header("location: denuncias.php");
    exit;
}
