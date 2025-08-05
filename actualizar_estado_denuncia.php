<?php
// actualizar_estado_denuncia.php
session_start();

// Proteger el script: solo usuarios logueados pueden actualizar
if (!isset($_SESSION["capacitacion_loggedin"]) || $_SESSION["capacitacion_loggedin"] !== true) {
    // Si alguien intenta acceder sin sesión, lo sacamos
    header("location: index.html");
    exit;
}

// Verificar que se está accediendo a través de un método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar que los datos necesarios (ID y nuevo estado) fueron enviados
    if (isset($_POST['denuncia_id']) && !empty($_POST['denuncia_id']) && isset($_POST['nuevo_estado'])) {

        require_once "db_config.php"; // Incluir la configuración de la base de datos

        // Validar y limpiar los datos de entrada
        $denuncia_id = intval($_POST['denuncia_id']); // Asegurarse de que el ID es un entero
        $nuevo_estado = $_POST['nuevo_estado'];
        $estados_permitidos = ['recibida', 'en_revision', 'resuelta'];

        // Asegurarse de que el nuevo estado sea uno de los valores permitidos
        if (in_array($nuevo_estado, $estados_permitidos)) {

            // Preparar la consulta UPDATE para evitar inyección SQL
            $sql = "UPDATE denuncias SET estado = ? WHERE id = ?";

            if ($stmt = $mysqli->prepare($sql)) {
                // Vincular los parámetros ('si' = string, integer)
                $stmt->bind_param("si", $param_estado, $param_id);

                // Establecer los valores de los parámetros
                $param_estado = $nuevo_estado;
                $param_id = $denuncia_id;

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Si tiene éxito, redirigir al panel con un mensaje de éxito
                    header("location: panel_denuncias.php?update_status=success");
                } else {
                    // Si falla, redirigir con un mensaje de error
                    header("location: panel_denuncias.php?update_status=error");
                }
                $stmt->close();
            } else {
                header("location: panel_denuncias.php?update_status=error");
            }
        } else {
            // Si el estado enviado no es válido
            header("location: panel_denuncias.php?update_status=error");
        }
        $mysqli->close();
    } else {
        // Si no se recibieron los datos esperados
        header("location: panel_denuncias.php?update_status=error");
    }
    exit;
} else {
    // Si alguien intenta acceder a este archivo directamente, redirigirlo
    header("location: panel_denuncias.php");
    exit;
}
