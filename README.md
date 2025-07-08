# Sitio Web Corporativo DISEI

## Descripción del Proyecto

Este repositorio contiene el código fuente del sitio web corporativo desarrollado para **DISEI**, una empresa especializada en la prestación de servicios eléctricos e industriales. El objetivo principal del sitio es presentar la empresa, sus servicios, trayectoria, proyectos destacados y facilitar el contacto, además de proveer un portal interno para la capacitación de sus empleados.

El sitio web está diseñado para ser informativo, profesional y fácil de navegar, con un diseño moderno y responsivo.

## Características Principales

- **Diseño Responsivo:** Adaptable a diferentes tamaños de pantalla (escritorio, tablets, móviles).
- **Navegación Intuitiva:** Menú principal y menú móvil para fácil acceso a todas las secciones.
- **Secciones Informativas:**
  - **Inicio:** Presentación general con carrusel de imágenes de proyectos y listado de servicios.
  - **Nosotros:** Información detallada sobre la empresa, incluyendo su historia (línea de tiempo), misión, visión, política integrada, código de conducta, valores y principios.
  - **Servicios:** Listado de los servicios ofrecidos, cada uno con una ventana modal que proporciona detalles adicionales, texto descriptivo y una imagen.
  - **Clientes:** Carruseles animados mostrando los logos de los principales clientes de la empresa.
  - **Proyectos:** Galería de proyectos destacados, cada uno con una ventana modal que incluye un carrusel de 5 imágenes y descripción detallada.
  - **Contacto:** Información de contacto, enlace a Google Maps, formulario para envío de CV (enlace a Google Forms) y un portal de acceso restringido para capacitaciones de empleados.
- **Portal de Capacitación para Empleados:**
  - Acceso restringido mediante contraseña.
  - Autenticación manejada con PHP y MySQL.
  - Hashing de contraseñas para seguridad.
  - Manejo de sesiones PHP.
  - Página protegida para mostrar materiales de capacitación (PDFs, imágenes).
- **Animaciones Sutiles:** Uso de AOS (Animate On Scroll) para mejorar la experiencia visual al desplazarse por las páginas.
- **Favicon:** Icono personalizado para el sitio.

## Tecnologías Utilizadas

### Frontend:

- **HTML5:** Estructura semántica del contenido.
- **CSS3:**
  - **Tailwind CSS:** Framework CSS utility-first para un desarrollo rápido y responsivo.
  - Estilos personalizados para elementos específicos (modales, línea de tiempo, etc.).
- **JavaScript (Vanilla JS):**
  - Manipulación del DOM para interactividad (menú móvil, carruseles, modales).
  - Integración con AOS.js.
- **AOS.js:** Librería para animaciones al hacer scroll.
- **Google Fonts:** Para la tipografía (Montserrat).

### Backend (Portal de Capacitación):

- **PHP:** Lenguaje de scripting del lado del servidor para la lógica de autenticación y manejo de sesiones.
- **MySQL (MariaDB):** Sistema de gestión de bases de datos para almacenar las credenciales de los usuarios del portal de capacitación.

### Herramientas de Desarrollo:

- **XAMPP:** Entorno de desarrollo local (Apache, MySQL, PHP).
- **Visual Studio Code:** Editor de código.
- **Git y GitHub:** Control de versiones y alojamiento del repositorio.

## Estructura del Proyecto

disei_web/
├── contacto.html
├── db_config.php # Configuración de la base de datos (con placeholders)
├── index.html
├── login_capacitacion.php # Lógica de login para el portal
├── logout_capacitacion.php # Lógica de logout para el portal
├── nosotros.html
├── portal_capacitacion.php # Página protegida de capacitación
├── proyectos.html
├── servicios.html
├── clientes.html
├── script.js # Scripts JS generales (menú móvil, carrusel inicio)
├── favicon.png # Favicon del sitio
├── README.md # Este archivo
├── img/ # Carpeta para imágenes generales y de páginas
│ ├── disei-logo.png
│ ├── edificio-disei.jpg
│ ├── proyecto1.jpg
│ └── ...
├── logos/ # Carpeta para logos de clientes
│ ├── cliente1.png
│ └── ...

## Configuración y Puesta en Marcha Local (Ejemplo con XAMPP)

1.  **Clonar el repositorio (o descargar el ZIP y extraer).**
2.  **Configurar XAMPP:**
    - Asegurarse de que los servicios de Apache y MySQL estén corriendo.
    - Colocar la carpeta del proyecto (ej. `disei_web`) dentro del directorio `htdocs` de XAMPP.
3.  **Base de Datos:**
    - Acceder a phpMyAdmin (`http://localhost/phpmyadmin/`).
    - Crear una nueva base de datos (ej. `disei_db`).
    - Importar o ejecutar el siguiente script SQL para crear la tabla `usuarios_capacitacion`:
    ```sql
    CREATE TABLE usuarios_capacitacion (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        nombre_completo VARCHAR(100)
    );
    ```
    - Insertar un usuario de prueba. Ejemplo (reemplazar el hash con uno generado para la contraseña deseada):
    ```sql
    INSERT INTO usuarios_capacitacion (username, password_hash, nombre_completo)
    VALUES ('empleado_disei', 'HASH_GENERADO_AQUI', 'Portal de Capacitación');
    ```
    (Para generar el hash, se puede usar un script PHP temporal con `password_hash('tu_contraseña', PASSWORD_DEFAULT);`)
4.  **Configurar `db_config.php`:**
    - Copiar `db_config.php.example` a `db_config.php` (si se usa una plantilla) o editar `db_config.php`.
    - Actualizar los placeholders con las credenciales de la base de datos local (ej. `DB_USERNAME = 'root'`, `DB_PASSWORD = ''`, `DB_NAME = 'disei_db'`).
5.  **Acceder al Sitio:**
    - Abrir en el navegador: `http://localhost/disei_web/index.html` (o el nombre de tu carpeta).

## Posibles Mejoras Futuras

- Implementar un sistema de gestión de contenido (CMS) para facilitar la actualización de textos e imágenes.
- Optimización avanzada de imágenes y carga diferida (lazy loading) para mejorar el rendimiento.
- Pruebas unitarias y de integración.
- Internacionalización (i18n) si se requiere soporte para múltiples idiomas.
- Mejorar la seguridad del portal de capacitación con medidas adicionales (ej. CSRF tokens, límite de intentos de login).

## Autor

- **Mariano Ressio Barea**
- marianoressio@gmail.com

---
