<?php
session_start();
if (!isset($_SESSION["capacitacion_loggedin"]) || $_SESSION["capacitacion_loggedin"] !== true) {
    header("location: contacto.html?error=auth_required");
    exit;
}
$nombreEmpleado = isset($_SESSION["capacitacion_nombre"]) ? htmlspecialchars($_SESSION["capacitacion_nombre"]) : "Empleado";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISEI - Portal de Capacitación</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        diseiBlue: '#323B82',
                    },
                    fontFamily: {
                        montserrat: ['Montserrat', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>

    </style>
</head>

<body class="bg-gray-100 font-montserrat text-gray-800 flex flex-col min-h-screen">

    <nav class="w-full bg-white shadow-lg z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex-shrink-0">
                <img src="img/logos/disei-logo.png" alt="DISEI Logo" class="h-12">
            </div>
            <div class="text-gray-800">
                <a href="logout_capacitacion.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold text-diseiBlue mb-8 text-center">Portal de Capacitación</h1>

        <div class="bg-white p-8 rounded-lg shadow-xl max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold text-diseiBlue mb-6">Materiales Disponibles</h2>
            <ul class="list-disc list-inside space-y-3 text-gray-700">
                <li class="mb-2">
                    <a href="https://drive.google.com/drive/folders/1p8NOOaz76uoJeIdRGsJMVhkTaZ_q3TJo?usp=drive_link" target="_blank"
                        class="text-diseiBlue hover:text-blue-700 underline hover:font-semibold transition-all">
                        Acceder a las capacitaciones (Google Drive)
                    </a>
                </li>
            </ul>
            <p class="mt-8 text-sm text-gray-500">
                Recuerda mantener la confidencialidad de estos materiales. Si tienes alguna pregunta, contacta a tu supervisor.
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-diseiBlue py-8 mt-12">
        <div
            class="container mx-auto px-6 sm:px-12 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 text-white text-sm">
            <div><img src="img/logos/disei-logo-white.png" alt="DISEI Logo" class="h-10 mx-auto md:mx-0 mb-4 md:mb-0"></div>
            <div class="flex-grow md:pl-6">
                <p>Corrientes 1060 Este, Capital, San Juan, Argentina</p>
                <p>Tel: +54 264 570-5969 | Email: disei@disei.com.ar</p>
            </div>
            <div class="mt-4 md:mt-0">
                © <?php echo date("Y"); ?> DISEI. Todos los derechos reservados.
            </div>
        </div>
    </footer>

</body>

</html>