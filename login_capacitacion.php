<?php
session_start();
if (isset($_SESSION["capacitacion_loggedin"]) && $_SESSION["capacitacion_loggedin"] === true) {
    header("location: portal_capacitacion.php");
    exit;
}


require_once "db_config.php";


$password = "";
$username_fijo = "empleado_disei";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["training_password"]))) {

        header("location: contacto.html?error=2");
    } else {
        $password = trim($_POST["training_password"]);
    }

    $sql = "SELECT id, username, password_hash, nombre_completo FROM usuarios_capacitacion WHERE username = ?";


    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("s", $param_username);

        $param_username = $username_fijo;

        if ($stmt->execute()) {

            $stmt->store_result();

            if ($stmt->num_rows == 1) {

                $stmt->bind_result($id, $username, $hashed_password_from_db, $nombre_completo);
                if ($stmt->fetch()) {


                    if (password_verify($password, $hashed_password_from_db)) {

                        $_SESSION["capacitacion_loggedin"] = true;
                        $_SESSION["capacitacion_id"] = $id;
                        $_SESSION["capacitacion_username"] = $username;
                        $_SESSION["capacitacion_nombre"] = $nombre_completo;

                        header("location: portal_capacitacion.php");
                    } else {


                        header("location: contacto.html?error=1");
                    }
                } else {
                }
            } else {

                header("location: contacto.html?error=3");
            }
        } else {

            header("location: contacto.html?error=generic_execute");
        }

        $stmt->close();
    } else {

        header("location: contacto.html?error=generic_prepare");
    }

    $mysqli->close();
} else {

    header("location: contacto.html");
}
