<?php

namespace Controllers;
use Services\CategoriasService;
use Lib\Pages;
use Models\Categoria; 
use Models\Validacion; 
use Services\UsuariosService; 
class UsuarioController {

    private Pages $pagina;
    private CategoriasService $categoriasService;
    private UsuariosService $usuariosService;
    private MailController $MailController;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->usuariosService = new UsuariosService();

        $this->MailController = new MailController();

    }

    public function mostrarUsuario($error = null) {
        // Obtener el email del usuario utilizando la función obtenerEmailUsuario
        $emailSesion = $this->obtenerEmailUsuario(null);
    
        // Si no hay email de sesión, redirigir a mostrarTodos en CategoriasController
        if (!$emailSesion) {
            $mensaje[] = "Tienes que registrarte para poder ver tu usuario";
            $WebController = new WebController();
            return $WebController->mostrarBienvenida($emailSesion, $mensaje);
        }
    
        // Obtén los datos del usuario autenticado
        $usuario = $this->usuariosService->obtenerUsuarioPorEmail($emailSesion);
        
        // Verificar si se encontró el usuario
        if (!$usuario) {
            return $this->pagina->render('error', ['message' => 'Usuario no encontrado.']);
        }
    
        // Obtén todas las propiedades del usuario
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $rol = $usuario->getRol();
        $nombre_usuario = $usuario->getUsuario();
        
    
        // Preparar los datos para renderizar la vista de usuario
        $data = compact('nombre', 'apellidos', 'nombre_usuario', 'email', 'rol');
    
        // Agregar el mensaje de error a los datos si está presente
        if ($error !== null) {
            $data['error_message'] = $error;
        }

        if ($rol == 'admin'){

            $usuarios = $this->usuariosService->obtenerUsuarios();
            $data['usuarios'] = $usuarios;
        }
    
        // Renderizar la vista de usuario pasando las propiedades del usuario y el mensaje de error si existe
        $this->pagina->render("Usuario/mostrarUsuario", $data);
        
    }

    public function sesion_usuario(): bool {
        // Inicia la sesión si no ha sido iniciada ya
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Verifica si el email del usuario está presente en la sesión
        return isset($_SESSION['email']);
    }

    // Función para obtener el email del usuario desde la sesión o la cookie
    function obtenerEmailUsuario($emailRecordado) {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Obtener el email de la sesión si está presente
        $emailSesion = isset($_SESSION['email']) ? $_SESSION['email'] : null;

        // Si no hay email en la sesión, intentar obtenerlo de la cookie
        if (!$emailSesion) {
            $emailSesion = $emailRecordado ?? (isset($_COOKIE['email_recordado']) ? $_COOKIE['email_recordado'] : null);
        }

        return $emailSesion;
    }
    

    public function actualizarUsuario($nombre, $apellidos, $email, $rol) {
        // Validar y sanear los datos
        $usuarioValidado = $this->validarSaneaUsuario($nombre, $apellidos, $rol);
        
        // Check if the user data is valid
        if (!$usuarioValidado) {
            // Handle invalid data, perhaps show an error message
            $error_message = "Error: Datos de usuario no válidos.";
            $this->mostrarUsuario($error_message);
            return;
        }
        $usuario = null;
        $usuarioController = new UsuarioController();

        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $usuario = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            // Verificar y asignar valores si son nulos
            }
        $nombre = $nombre !== null ? $nombre : $usuario->getNombre();
        $apellidos = $apellidos !== null ? $apellidos : $usuario->getApellidos();


    
        // Continuar con la actualización del usuario utilizando los campos saneados
        $resultado = $this->usuariosService->actualizarUsuario(
            $usuarioValidado['nombre'],
            $usuarioValidado['apellidos'],
            $email, // no se lleva a validar, dado que es el campo identificativo en esta aplicación
            $usuarioValidado['rol']
        );
    
        if ($resultado === null) {
            // Redirigir a mostrar usuario si la actualización es exitosa
            $this->mostrarUsuario();
        } else {
            // Manejo de error si ocurre algún problema al actualizar el usuario
            $this->mostrarUsuario($resultado);
        }
    }
    
    public function validarSaneaUsuario( $nombre, $apellidos, $rol) {
        // Validar los valores
        $errores = Validacion::validarDatosUsuario($nombre, $apellidos, $rol);
    
        // Si hay errores, asignar el mensaje de error a una variable
        if (!empty($errores)) {
            $this->mostrarUsuario($errores);
            // Renderiza la vista de usuario pasando las propiedades del usuario
            

            return false; // Indicar que hubo errores
        }
    
        // Saneamiento de los campos
        $usuarioSaneado = Validacion::sanearCamposUsuario($nombre, $apellidos, $rol);
        
        // Asignar los valores saneados de vuelta a las variables originales
        
        // Devolver los campos saneados
        return $usuarioSaneado;
    }

    public function borrarUsuario($usuario_id) {

         // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario(null);

        // Verifica si el usuario está autenticado y obtenemos su rol
        if ($usuarioController->sesion_usuario()) {
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            $rol = $email->getRol();
        }

        if ($rol === 'admin'){
            $guardadoExitoso = $this->usuariosService->borrarUsuario($usuario_id);
            // Verificar el resultado y establecer el mensaje correspondiente
        if ($guardadoExitoso) {
            $mensaje = "Borrado de usuario exitoso.";
        } else {
            $mensaje = "Error al crear al borrar el usuario. Tiene algún pedido o cita establecida y por eso no se puede ni se debe borrar del sistema.";
            // No se debe borrar del sistema este tipo de usuarios porque tenemos que guardar un registro de los pedidos que se han realizado, ya sean de productos, o usuarios.
            // La bbdd no tiene ningún sentido si se pueden borrar este tipo de cosas.

        }
       
        } else {
            $mensaje = "Tienes que tener permisos de administrador para poder borrar un usuario";
            
        }      

    $this->mostrarUsuario($mensaje);

    }
    
}


