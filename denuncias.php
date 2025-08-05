<?php
// denuncias.php
$mensaje = '';
$tipoMensaje = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $mensaje = 'Su denuncia ha sido enviada con éxito. Agradecemos su colaboración.';
        $tipoMensaje = 'success';
    } elseif ($_GET['status'] == 'error') {
        $mensaje = 'Ocurrió un error al enviar su denuncia. Por favor, inténtelo de nuevo.';
        $tipoMensaje = 'error';
    } elseif ($_GET['status'] == 'empty') {
        $mensaje = 'El campo de la denuncia no puede estar vacío.';
        $tipoMensaje = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISEI - Portal de Denuncias</title>
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
</head>

<body class="bg-gray-50 font-montserrat text-gray-800 flex flex-col min-h-screen">
    <nav class="fixed top-0 w-full bg-white shadow-lg z-50">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex-shrink-0">
                <img src="img/logos/disei-logo.png" alt="DISEI Logo" class="h-12">
            </div>
            <button id="menu-btn" class="text-diseiBlue md:hidden focus:outline-none text-3xl">☰</button>
            <ul id="menu" class="hidden md:flex space-x-6 text-gray-800 font-normal uppercase">
                <li><a href="index.html" class="hover:text-diseiBlue">Inicio</a></li>
                <li><a href="nosotros.html" class="hover:text-diseiBlue">Nosotros</a></li>
                <li><a href="servicios.html" class="hover:text-diseiBlue">Servicios</a></li>
                <li><a href="clientes.html" class="hover:text-diseiBlue">Clientes</a></li>
                <li><a href="proyectos.html" class="hover:text-diseiBlue">Proyectos</a></li>
                <li><a href="integridad.html" class="hover:text-diseiBlue">Integridad</a></li>
                <li><a href="contacto.html" class="hover:text-diseiBlue">Contacto</a></li>
            </ul>
        </div>
        <div id="mobile-menu" class="md:hidden hidden px-6 pb-4">
            <ul class="space-y-2 text-gray-800 font-normal uppercase">
                <li><a href="index.html" class="block hover:text-diseiBlue">Inicio</a></li>
                <li><a href="nosotros.html" class="block hover:text-diseiBlue">Nosotros</a></li>
                <li><a href="servicios.html" class="block hover:text-diseiBlue">Servicios</a></li>
                <li><a href="clientes.html" class="block hover:text-diseiBlue">Clientes</a></li>
                <li><a href="proyectos.html" class="block hover:text-diseiBlue">Proyectos</a></li>
                <li><a href="integridad.html" class="block hover:text-diseiBlue">Integridad</a></li>
                <li><a href="contacto.html" class="block hover:text-diseiBlue">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <main class="pt-32 pb-16 flex-1">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-4xl font-bold text-diseiBlue mb-4">Portal de Denuncias Anónimas</h1>
                <p class="text-lg text-gray-700 leading-relaxed text-justify">
                    Este es un canal seguro y confidencial para informar sobre cualquier conducta que considere contraria a nuestros principios éticos y Código de Conducta. Su denuncia será tratada con la máxima discreción. El anonimato está garantizado.
                </p>
            </div>

            <div class="max-w-2xl mx-auto mt-12 bg-white p-8 rounded-lg shadow-xl">
                <?php if ($mensaje): ?>
                    <div class="mb-6 p-4 rounded-md <?php echo $tipoMensaje == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>

                <form action="procesar_denuncia.php" method="POST">
                    <!-- NUEVO CAMPO DESPLEGABLE -->
                    <div class="mb-6">
                        <label for="tipo_denuncia" class="block text-gray-700 text-sm font-bold mb-2">
                            Tipo de Denuncia <span class="text-red-500">*</span>
                        </label>
                        <select id="tipo_denuncia" name="tipo_denuncia" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-diseiBlue">
                            <option value="" disabled selected>Seleccione una categoría</option>
                            <option value="Acoso o Discriminacion">Acoso o Discriminación</option>
                            <option value="Conflicto de Intereses">Conflicto de Intereses</option>
                            <option value="Corrupcion o Fraude">Corrupción o Fraude</option>
                            <option value="Medio Ambiente">Medio Ambiente</option>
                            <option value="Seguridad y Salud en el Trabajo">Seguridad y Salud en el Trabajo</option>
                            <option value="Uso Indebido de Activos">Uso Indebido de Activos de la Empresa</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="denuncia_texto" class="block text-gray-700 text-sm font-bold mb-2">
                            Descripción de la Situación <span class="text-red-500">*</span>
                        </label>
                        <textarea id="denuncia_texto" name="denuncia_texto" rows="8" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-diseiBlue" placeholder="Por favor, describa la situación con el mayor detalle posible (quién, qué, cuándo, dónde). No incluya información personal si desea permanecer anónimo."></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="contacto_opcional" class="block text-gray-700 text-sm font-bold mb-2">
                            Información de Contacto (Opcional)
                        </label>
                        <input type="text" id="contacto_opcional" name="contacto_opcional" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-diseiBlue" placeholder="Email o teléfono si desea que lo contactemos">
                        <p class="text-xs text-gray-500 mt-1">Dejar este campo en blanco garantiza su total anonimato.</p>
                    </div>

                    <div class="flex items-center justify-center">
                        <button type="submit" class="bg-diseiBlue text-white font-bold py-3 px-8 rounded-lg hover:bg-diseilightBlue focus:outline-none focus:shadow-outline transition-all transform hover:scale-105">
                            Enviar Denuncia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-diseiBlue py-8 mt-12">
        <div
            class="container mx-auto px-6 sm:px-12 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 text-white text-sm">
            <div><img src="img/logos/disei-logo-white.png" alt="DISEI Logo" class="h-10 mx-auto md:mx-0 mb-4 md:mb-0">
            </div>
            <div class="flex-grow md:pl-6">
                <p>Corrientes 1060 Este, Capital, San Juan, Argentina</p>
                <p>Tel: +54 264 570-5969 | Email: disei@disei.com.ar</p>
            </div>
            <div class="mt-4 md:mt-0">
                © DISEI. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 50,
                    disable: 'mobile'
                });

            }
        });
    </script>
</body>

</html>