<?php

namespace Controllers;
use Services\MedicosService;
use Lib\Pages;
use Models\Medico; 
use Models\Validacion; 
use Services\UsuariosService; 


class medicosController {

    private Pages $pagina;
    private MedicosService $medicosService;

    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->medicosService = new MedicosService();

        $this->usuariosService = new UsuariosService();
    }

    public function mostrarTodos($emailRecordado = null, $mensaje = ''): void
    {
        $medicosModel = $this->todasmedicos();
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        $rol = 'usur';
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            $rol = $email->getRol();
            $usuario_id = $email->getId(); }

        // Devolver la renderización de la página con los objetos de categoría, el correo electrónico de la sesión y el mensaje
        $this->pagina->render('Medico/mostrarMedicos', [
            'medicos' => $medicosModel, 
            'emailSesion' => $emailSesion, 
            'mensaje' => $mensaje,
            'rol' => $rol,
            'usuario_id' => $usuario_id
        ]);
    }

    public function todasmedicos(): array {
        // Obtener todas las categorías
        $medicos = $this->medicosService->obtenermedicos();

        // Crear un array para almacenar los objetos de categoría
        $medicosModel = [];
        foreach ($medicos as $medico) {
            // Crear una nueva instancia de medico con los datos de la categoría
            $medicoModel = new Medico();
            $medicoModel->setId($medico['id']);
            $medicoModel->setNombre($medico['nombre']);
            $medicoModel->setApellidos($medico['apellidos']);
            $medicoModel->setTelefono($medico['telefono']);
            $medicoModel->setEmail($medico['email']);
            $medicoModel->setUsuarioId($medico['usuario_id']);

            // Agregar la instancia de medico al array
            $medicosModel[] = $medicoModel;
        }
        return $medicosModel;
    }

    public function registromedico($nombremedico, $apellidosmedico, $telefonomedico, $emailmedico, $usuario_id):void {
        $mensaje = 'Regístrate como admin para crear el medico'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                $nombremedico = Validacion::saneamientoString($nombremedico);
                $apellidosmedico = Validacion::saneamientoString($apellidosmedico);
                $telefonomedico = Validacion::saneartelefono($telefonomedico);
                $usuario_id = Validacion::sanearNumero($usuario_id);
                if (empty($nombremedico) || empty($apellidosmedico) || empty($telefonomedico) || empty($usuario_id) || empty($emailmedico)) {
             
                    // Si el nombre de la categoría está vacío, asignar un mensaje de error
                    $mensaje = "Debe proporcionar todos los campos para el nuevo medico de forma correcta. Revisa de introducir solo los campos correctos para el teléfono (números con los iconos de + y separadores -)";
                } else {
                    // Guardar la nueva categoría si no está vacía
                     // Intentar guardar el medico
                    $guardadoExitoso = $this->medicosService->guardarmedico($nombremedico, $apellidosmedico, $telefonomedico, $emailmedico, $usuario_id);

                    // Verificar el resultado y establecer el mensaje correspondiente
                    if ($guardadoExitoso) {
                        $mensaje = "medico creado exitosamente.";
                    } else {
                        $mensaje = "Error al crear el medico. Por favor, inténtelo de nuevo.";
                    }
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevos medicos.";
            }
        }
        
        $this-> mostrarTodos($email, $mensaje);
    }


}
