# Sitio Web Corporativo DISEI

## Descripción del Proyecto

Este repositorio contiene el código fuente del sitio web corporativo desarrollado para **DISEI**, una empresa especializada en la prestación de servicios eléctricos e industriales. El objetivo principal del sitio es presentar la empresa, sus servicios, trayectoria, proyectos destacados y facilitar el contacto, además de proveer un portal interno para la capacitación de sus empleados y un panel para la gestión de denuncias.

El sitio web está diseñado para ser informativo, profesional y fácil de navegar, con un diseño moderno y responsivo.

## Características Principales

- **Diseño Responsivo:** Adaptable a diferentes tamaños de pantalla.
- **Navegación Intuitiva:** Menú de navegación completo y funcional en vistas de escritorio y móvil.
- **Secciones Informativas Detalladas:**
  - **Inicio:** Presentación general con carrusel de imágenes y listado de servicios.
  - **Nosotros:** Información completa sobre la empresa, incluyendo su historia a través de una **línea de tiempo animada**, misión, visión, política integrada, código de conducta, valores y principios.
  - **Servicios:** Catálogo de servicios con **ventanas modales interactivas** que proporcionan detalles, texto descriptivo y una imagen para cada servicio.
  - **Clientes:** Carruseles animados mostrando los logos de los principales clientes.
  - **Proyectos:** Galería de proyectos destacados, cada uno con un **modal que incluye un carrusel de 5 imágenes** y descripción detallada.
  - **Integridad y Canal de Denuncias:** Página dedicada con información sobre la política de integridad de la empresa y los diferentes canales para realizar denuncias (portal web, correo, teléfono).
  - **Contacto:** Información de contacto y acceso al portal interno.
- **Portal Interno con Doble Rol (PHP/MySQL):**
  - **Portal de Capacitación para Empleados:** Acceso restringido por usuario y contraseña. Muestra materiales de capacitación (PDFs, imágenes) una vez autenticado.
  - **Panel de Administración de Denuncias:** Acceso restringido para administradores. Permite visualizar todas las denuncias recibidas en una tabla, ver los detalles completos de cada una en un modal, y **actualizar el estado de gestión** de cada denuncia ("Recibida", "En Revisión", "Resuelta").
- **Portal de Denuncias Anónimas (Público):**
  - Formulario público y seguro para que cualquier persona pueda enviar una denuncia de forma anónima o proporcionando contacto opcional.
  - Clasificación de denuncias por tipo a través de un menú desplegable.
  - Almacenamiento seguro en la base de datos.
- **Seguridad:**
  - Uso de declaraciones preparadas de PHP para prevenir inyección SQL.
  - Hashing de contraseñas con `password_hash()` y verificación con `password_verify()`.
  - Manejo seguro de sesiones PHP.
- **Animaciones Sutiles:** Uso de AOS (Animate On Scroll) para mejorar la experiencia visual.

## Tecnologías Utilizadas

### Frontend:

- **HTML5:** Estructura semántica del contenido.
- **CSS3:**
  - **Tailwind CSS:** Framework CSS utility-first para un desarrollo rápido y responsivo.
  - Estilos personalizados para elementos específicos (modales, línea de tiempo, etc.).
- **JavaScript (Vanilla JS):** Manipulación del DOM para toda la interactividad.
- **AOS.js:** Librería para animaciones al hacer scroll.

### Backend (Portal Interno y Denuncias):

- **PHP:** Lenguaje de scripting del lado del servidor para toda la lógica de negocio.
- **MySQL (MariaDB):** Sistema de gestión de bases de datos.

### Herramientas de Desarrollo:

- **XAMPP:** Entorno de desarrollo local (Apache, MySQL, PHP).
- **Visual Studio Code:** Editor de código.
- **Git y GitHub:** Control de versiones.

## Estructura del Proyecto

disei_web/
├── index.html (antes inicio.html)
├── nosotros.html, servicios.html, clientes.html, proyectos.html, contacto.html
├── integridad.html # Página de Integridad
├── denuncias.php # Formulario público de denuncias
├── procesar_denuncia.php # Script que guarda las denuncias
├── panel_denuncias.php # Panel de administración de denuncias
├── actualizar_estado_denuncia.php # Script que actualiza el estado de una denuncia
├── portal_capacitacion.php # Portal de empleados
├── login_capacitacion.php # Lógica de login para ambos roles
├── logout_capacitacion.php # Lógica de logout
├── db_config.php # Configuración de la base de datos (con placeholders)
├── script.js
├── favicon.ico
├── README.md
├── img/, logos/, documentos/ # Carpetas de Assets

## Configuración y Puesta en Marcha Local

1.  **Configurar XAMPP:** Iniciar Apache y MySQL. Colocar la carpeta del proyecto en `htdocs`.
2.  **Base de Datos:**
    - Crear una base de datos en phpMyAdmin (ej. `disei_db`).
    - Ejecutar los siguientes scripts SQL para crear las tablas:
    ```sql
    -- Tabla para usuarios del portal interno
    CREATE TABLE usuarios_capacitacion (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        nombre_completo VARCHAR(100)
    );
    -- Tabla para las denuncias
    CREATE TABLE denuncias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tipo_denuncia VARCHAR(255) NOT NULL,
        denuncia_texto TEXT NOT NULL,
        contacto_opcional VARCHAR(255) DEFAULT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        estado ENUM('recibida', 'en_revision', 'resuelta') NOT NULL DEFAULT 'recibida'
    );
    ```
    - Insertar los usuarios de prueba (empleado y admin) generando sus respectivos hashes con `password_hash()`.
3.  **Configurar `db_config.php`:** Actualizar con las credenciales de la base de datos local.
4.  **Acceder al Sitio:** Abrir `http://localhost/nombre_carpeta_proyecto/index.html`.

## Autor

- **Mariano Ressio Barea**
- https://www.linkedin.com/in/mariano-ressio
