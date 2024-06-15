<?php

namespace Controllers;

use Lib\Pages;
use Models\Validacion; 
use Services\UsuariosService; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class RegistroController {

    private Pages $pagina;
    private UsuariosService $usuariosService;
    private MailController $MailController;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        
        $this->usuariosService = new UsuariosService();
        $this->loginController = new LoginController();
        $this->MailController = new MailController();
        

    }

    public function mostrarRegistro($emailRecordado = null, $mensajeError = null) {

        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        $rol = 'docente';
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            // Verifica si el usuario tiene permisos de administrador
            $rol = $email->getRol();
            }
        
        $this->pagina->render("Registro/mostrarRegistro", ['rol' => $rol, 'mensajeError'=>$mensajeError]);
    }

    public function registroUsuario($nombre, $apellidos, $usuario, $email, $contrasena) {
        // Verificar si se ha enviado el formulario de registro
    
        $errores = [];

        // Verificar y sanear el usuario
        $usuario = Validacion::sanearUsuario($usuario);
        if ($usuario === null) {
            $errores[] = "Usuario no válido. El usuario solo puede estar formado por letras y números.";
        }

        // Validar la contraseña
        if (!Validacion::validarContrasena($contrasena)) {
            $errores[] = "Contraseña no es válida. La contraseña tenga al menos 7 caracteres , de los cuales al menos uno debe ser una letra mayúscula , un dígito y al menos uno de los siguientes caracteres especiales #!@*$.";
        }

        // Si hay errores, mostrarlos
        if (!empty($errores)) {
            $this->mostrarRegistro(null, $errores);
            return;
        }
        

        $usuariosService = new UsuariosService();
        //adaptar este valor en función de los parámetros que entren por defecto
        $rol = 'usur'; 
        
        // Registro de usuarios en la base de datos
        $resultado = $usuariosService->register($nombre, $apellidos, $usuario, $email, $contrasena, $rol);
        

        // Envío del email de registro
        $MailController = new MailController();
        $MailController->mailregistro($nombre, $email);
    
        $webController = new WebController();
        $webController->mostrarBienvenida();
    }
    
        

}