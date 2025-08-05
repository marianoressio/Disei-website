<?php
// login_capacitacion.php
session_start();

// Si el usuario ya está autenticado, redirigirlo a su portal correspondiente
if (isset($_SESSION["capacitacion_loggedin"]) && $_SESSION["capacitacion_loggedin"] === true) {
    if ($_SESSION["capacitacion_username"] === 'admin_disei') {
        header("location: panel_denuncias.php");
    } else {
        header("location: portal_capacitacion.php");
    }
    exit;
}

require_once "db_config.php";

$password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar que los campos no estén vacíos
    if (empty(trim($_POST["training_username"])) || empty(trim($_POST["training_password"]))) {
        header("location: contacto.html?error=empty_fields");
        exit;
    } else {
        $username_post = trim($_POST["training_username"]);
        $password = trim($_POST["training_password"]);
    }

    $sql = "SELECT id, username, password_hash, nombre_completo FROM usuarios_capacitacion WHERE username = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $param_username);
        $param_username = $username_post;

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username_db, $hashed_password_from_db, $nombre_completo);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password_from_db)) {
                        // La contraseña es correcta, iniciar sesión

                        // Regenerar ID de sesión por seguridad
                        session_regenerate_id(true);

                        $_SESSION["capacitacion_loggedin"] = true;
                        $_SESSION["capacitacion_id"] = $id;
                        $_SESSION["capacitacion_username"] = $username_db;
                        $_SESSION["capacitacion_nombre"] = $nombre_completo;

                        // ***** AQUÍ VA LA LÓGICA DE REDIRECCIÓN CONDICIONAL *****
                        if ($username_db === 'admin_disei') {
                            header("location: panel_denuncias.php");
                        } else {
                            header("location: portal_capacitacion.php");
                        }
                        exit;
                    } else {
                        // Contraseña incorrecta
                        header("location: contacto.html?error=1");
                        exit;
                    }
                }
            } else {
                // Usuario no encontrado
                header("location: contacto.html?error=3");
                exit;
            }
        } else {
            // Error de ejecución
            header("location: contacto.html?error=generic_execute");
            exit;
        }
        $stmt->close();
    } else {
        // Error de preparación
        header("location: contacto.html?error=generic_prepare");
        exit;
    }
    $mysqli->close();
} else {
    // Si no es POST, redirigir
    header("location: contacto.html");
    exit;
}
