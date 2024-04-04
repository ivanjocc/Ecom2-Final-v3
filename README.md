# Proyecto de Registro y Perfil de Usuario

Este es un proyecto simple de registro y perfil de usuario en PHP utilizando MySQL para almacenar la información del usuario.

## Estructura del Proyecto

- `config/`: Contiene archivos de configuración, como `database.php`.
- `models/`: Contiene las clases de modelo, como `User.php`.
- `public/`: Contiene archivos públicos, como hojas de estilo CSS y JavaScript.
- `views/`: Contiene archivos de vista, como `login.php`, `register.php`, `profile.php`, etc.

## Configuración del Proyecto

1. Configura tu base de datos MySQL y actualiza la información en `config/database.php`.
2. Importa el archivo SQL proporcionado para crear las tablas necesarias en tu base de datos.

## Uso

1. Registra un nuevo usuario en `register.php`.
2. Inicia sesión con tus credenciales en `login.php`.
3. Accede al perfil del usuario en `profile.php`.
4. Cambia la contraseña en `change_password.php`.

## Archivos Principales

- `register.php`: Formulario de registro de usuario.
- `login.php`: Formulario de inicio de sesión.
- `profile.php`: Perfil de usuario y formulario para actualizar información.
- `change_password.php`: Formulario para cambiar la contraseña del usuario.
- `process_register.php`: Procesa el formulario de registro.
- `process_login.php`: Procesa el formulario de inicio de sesión.
- `process_update_profile.php`: Procesa el formulario para actualizar el perfil.
- `process_change_password.php`: Procesa el formulario para cambiar la contraseña.

## Contribuciones

Las contribuciones son bienvenidas. Si encuentras algún problema o tienes sugerencias, por favor crea un problema o envía una solicitud de extracción.

## Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.
