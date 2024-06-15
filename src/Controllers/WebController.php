<?php

namespace Controllers;

use Lib\Pages;
use Services\UsuariosService;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class WebController{
    private Pages $pagina;
    private UsuariosService $usuariosService;

    public function __construct() {
        $this->pagina = new Pages();
        $this->usuariosService = new UsuariosService();
    }

    public function mostrarBienvenida($emailRecordado=null, $mensajeError=null): void {

        // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            }

        // Verificar si hay errores y convertir a array si es necesario
        if (!is_array($mensajeError) && $mensajeError !== null) {
            $mensajeError = [$mensajeError];
        }



        $this->pagina->render('mostrarBienvenida', ['emailSesion' => $emailSesion, 'mensajeError'=>$mensajeError]);
        
    }
}