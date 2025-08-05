<?php
// panel_denuncias.php
session_start();

// Verificar si el usuario está logueado, si no, redirigir a la página de login
// Podrías crear un admin_login.html o redirigir a la página de inicio
if (!isset($_SESSION["capacitacion_loggedin"]) || $_SESSION["capacitacion_loggedin"] !== true) {
    header("location: index.html"); // O a una página de login específica para el admin
    exit;
}

// Incluir la configuración de la base de datos
require_once "db_config.php";

$sql = "SELECT id, tipo_denuncia, denuncia_texto, contacto_opcional, fecha_creacion, estado FROM denuncias ORDER BY fecha_creacion DESC";
$denuncias = [];
if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $denuncias[] = $row;
        }
    }
    $result->free();
} else {
    $error_consulta = "ERROR: No se pudo ejecutar la consulta. " . $mysqli->error;
}
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración de Denuncias - DISEI</title>
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
        /* Estilos para el Modal (reutilizados de otras páginas) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        .modal-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 2rem;
            color: #4a5568;
            cursor: pointer;
            line-height: 1;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-gray-100 font-montserrat text-gray-800 flex flex-col min-h-screen flex flex-col min-h-screen">
    <nav class="w-full bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex-shrink-0">
                <img src="img/logos/disei-logo.png" alt="DISEI Logo" class="h-12">
            </div>
            <div class="text-gray-800">
                <span class="mr-4">Panel de Administración</span>
                <a href="logout_capacitacion.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8 flex-1">
        <h1 class="text-3xl font-bold text-diseiBlue mb-6">Denuncias Recibidas</h1>

        <!-- Bloque para mostrar mensajes de éxito/error de la actualización -->
        <?php if (isset($_GET['update_status'])): ?>
            <div class="mb-4 p-4 rounded-md <?php echo $_GET['update_status'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php
                if ($_GET['update_status'] == 'success') {
                    echo 'El estado de la denuncia ha sido actualizado correctamente.';
                } else {
                    echo 'Error al actualizar el estado de la denuncia.';
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-xl overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Resumen</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado Actual</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($denuncias)): ?>
                        <tr>
                            <td colspan="5" class="text-center p-4">No hay denuncias recibidas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($denuncias as $denuncia): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($denuncia['fecha_creacion']))); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <?php echo htmlspecialchars($denuncia['tipo_denuncia']); ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <span class="cursor-pointer text-diseiBlue hover:underline" onclick="openModal('modal-denuncia-<?php echo $denuncia['id']; ?>')">
                                        <?php echo htmlspecialchars(substr($denuncia['denuncia_texto'], 0, 50)); ?>...
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <?php
                                    // Definir clases de color basadas en el estado
                                    $estadoClases = '';
                                    switch ($denuncia['estado']) {
                                        case 'recibida':
                                            $estadoClases = 'bg-blue-200 text-blue-900';
                                            break;
                                        case 'en_revision':
                                            $estadoClases = 'bg-yellow-200 text-yellow-900';
                                            break;
                                        case 'resuelta':
                                            $estadoClases = 'bg-green-200 text-green-900';
                                            break;
                                        default:
                                            $estadoClases = 'bg-gray-200 text-gray-900';
                                    }

                                    // Reemplazar guion bajo con espacio para mostrarlo
                                    $estadoTexto = str_replace('_', ' ', $denuncia['estado']);
                                    ?>
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight rounded-full <?php echo $estadoClases; ?>">
                                        <?php echo htmlspecialchars(ucfirst($estadoTexto)); ?>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <!-- Formulario para actualizar estado (sin cambios aquí) -->
                                    <form action="actualizar_estado_denuncia.php" method="POST" class="flex items-center gap-2">
                                        <input type="hidden" name="denuncia_id" value="<?php echo $denuncia['id']; ?>">
                                        <select name="nuevo_estado" class="form-select appearance-none block w-full px-2 py-1 text-sm text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-diseiBlue focus:outline-none">
                                            <option value="recibida" <?php if ($denuncia['estado'] == 'recibida') echo 'selected'; ?>>Recibida</option>
                                            <option value="en_revision" <?php if ($denuncia['estado'] == 'en_revision') echo 'selected'; ?>>En Revisión</option>
                                            <option value="resuelta" <?php if ($denuncia['estado'] == 'resuelta') echo 'selected'; ?>>Resuelta</option>
                                        </select>
                                        <button type="submit" class="bg-diseiBlue text-white text-xs font-bold py-1 px-3 rounded hover:bg-diseilightBlue transition-colors">
                                            Actualizar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODALES (Se generan dinámicamente) -->
    <?php foreach ($denuncias as $denuncia): ?>
        <div id="modal-denuncia-<?php echo $denuncia['id']; ?>" class="modal-overlay" onclick="closeModalIfOverlay(event, 'modal-denuncia-<?php echo $denuncia['id']; ?>')">
            <div class="modal-content">
                <button class="modal-close-btn" onclick="closeModal('modal-denuncia-<?php echo $denuncia['id']; ?>')">×</button>
                <h2 class="text-2xl font-bold text-diseiBlue mb-2">Detalle de Denuncia #<?php echo $denuncia['id']; ?></h2>
                <p class="text-sm text-gray-500 mb-4">Recibida el: <?php echo htmlspecialchars(date('d/m/Y \a \l\a\s H:i', strtotime($denuncia['fecha_creacion']))); ?></p>

                <div class="border-t border-b border-gray-200 py-4 my-4">
                    <h3 class="font-semibold text-gray-800">Tipo de Denuncia:</h3>
                    <p class="text-gray-700"><?php echo htmlspecialchars($denuncia['tipo_denuncia']); ?></p>

                    <h3 class="font-semibold text-gray-800 mt-4">Descripción Completa:</h3>
                    <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($denuncia['denuncia_texto']); ?></p>

                    <h3 class="font-semibold text-gray-800 mt-4">Contacto (Opcional):</h3>
                    <p class="text-gray-700"><?php echo $denuncia['contacto_opcional'] ? htmlspecialchars($denuncia['contacto_opcional']) : 'Anónimo'; ?></p>

                    <h3 class="font-semibold text-gray-800 mt-4">Estado Actual:</h3>
                    <p class="text-gray-700"><?php echo htmlspecialchars(ucfirst($denuncia['estado'])); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });
        });

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        function closeModalIfOverlay(event, modalId) {
            if (event.target.id === modalId) {
                closeModal(modalId);
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                const activeModals = document.querySelectorAll('.modal-overlay.active');
                activeModals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });
    </script>
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
</body>

</html>