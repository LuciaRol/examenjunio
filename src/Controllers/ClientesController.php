<?php

namespace Controllers;
use Services\ClientesService;
use Lib\Pages;
use Models\Cliente; 
use Models\Validacion; 
use Services\UsuariosService; 


class ClientesController {

    private Pages $pagina;
    private ClientesService $ClientesService;

    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de categorías
        $this->ClientesService = new ClientesService();

        $this->usuariosService = new UsuariosService();
    }

    public function mostrarTodos($emailRecordado = null, $mensaje = ''): void
    {
        $ClientesModel = $this->todasClientes();
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        $rol = 'usur';
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            $rol = $email->getRol(); }

        // Devolver la renderización de la página con los objetos de categoría, el correo electrónico de la sesión y el mensaje
        $this->pagina->render('Clientes/mostrarClientes', [
            'Clientes' => $ClientesModel, 
            'emailSesion' => $emailSesion, 
            'mensaje' => $mensaje,
            'rol' => $rol
        ]);
    }

    public function todasClientes(): array {
        // Obtener todas las categorías
        $Clientes = $this->ClientesService->obtenerClientes();

        // Crear un array para almacenar los objetos de categoría
        $ClientesModel = [];
        foreach ($Clientes as $Cliente) {
            // Crear una nueva instancia de Cliente con los datos de la categoría
            $ClienteModel = new Cliente();
            $ClienteModel->setId($Cliente['id']);
            $ClienteModel->setNombre($Cliente['nombre']);
            // Agregar la instancia de Cliente al array
            $ClientesModel[] = $ClienteModel;
        }
        return $ClientesModel;
    }

    /*public function registroCliente($nombreCliente):void {
        $mensaje = 'Regístrate como admin para crear la categoría'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                $nombreCliente = Validacion::sanearCliente($nombreCliente);
                

                if (empty($nombreCliente)) {
                    // Si el nombre de la categoría está vacío, asignar un mensaje de error
                    $mensaje = "Debe proporcionar un nombre para la nueva categoría.";
                } else {
                    // Guardar la nueva categoría si no está vacía
                    $this->ClientesService->guardarCliente($nombreCliente);
                    $mensaje = "Categoría creada exitosamente.";
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevas categorías.";
            }
        }
        
        $this-> mostrarTodos($email, $mensaje);
    }

*/
}
