<?php

namespace Controllers;
use Lib\Pages;
use Models\Validacion; 
use Services\UsuariosService; 

class LoginController {

    private Pages $pagina;
    private UsuariosService $usuariosService;
    private MailController $MailController;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        
        $this->usuariosService = new UsuariosService();

        $this->MailController = new MailController();
        $this->WebController = new WebController();
    }

    public function mostrarLogin($emailRecordado=null): void {
        // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            }

        $this->pagina->render('Login/mostrarLogin', ['emailSesion' => $emailSesion]);
        
    }


    public function login($email, $password) {
        
        $error = ''; // Creamos esta variable para que si todo va bien, no de error al mostrarBlog
    
        if ($email && $password) {
            $user = $this->usuariosService->verificaCredenciales($email, $password);
            if ($user) {
                session_start();
                $_SESSION['email'] = $user->getEmail();
                
                // Si se marca la casilla de "recordar usuario", establecer la cookie
                
                // Establecer el nombre de usuario como valor de la cookie
                setcookie("email_recordado", $user->getEmail(), time() + (30 * 24 * 60 * 60), "/");
                
                
            } else {
                $error = 'Email o contraseña incorrecta';
            }
        } 
    
        // Verificar si la cookie "email_recordado" existe y establecer la variable $emailRecordado
        $emailRecordado = isset($_COOKIE['email_recordado']) ? $_COOKIE['email_recordado'] : null;
        //$usuarioRecordado = isset($_COOKIE['usuario_recordado']) ? $_COOKIE['usuario_recordado'] : null;
    
        // Llama a mostrarBlog con el posible mensaje de error del login y la variable $emailRecordado
        $WebController = new WebController();

        return $WebController->mostrarBienvenida($emailRecordado); // este parámetro se cambia por email recordado en función de si me quiero logear con usuario o email
        
    }

    public function logout() {
        // Inicia la sesión si no ha sido iniciada ya
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Destruye la sesión
        session_destroy();
    
        // Elimina la cookie de email_recordado si existe
        if (isset($_COOKIE['email_recordado'])) {
            unset($_COOKIE['email_recordado']);
            setcookie('email_recordado', '', time() - 3600, '/');
        }
    
        // Redirige a Bienvenida
        $WebController = new WebController();

        return $WebController->mostrarBienvenida();
    }
       
}


