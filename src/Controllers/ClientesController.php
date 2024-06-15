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
            $rol = $email->getRol();
            $usuario_id = $email->getId(); }

        // Devolver la renderización de la página con los objetos de categoría, el correo electrónico de la sesión y el mensaje
        $this->pagina->render('Clientes/mostrarClientes', [
            'Clientes' => $ClientesModel, 
            'emailSesion' => $emailSesion, 
            'mensaje' => $mensaje,
            'rol' => $rol,
            'usuario_id' => $usuario_id
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
            $ClienteModel->setApellidos($Cliente['apellidos']);
            $ClienteModel->setTelefono($Cliente['telefono']);
            $ClienteModel->setEmail($Cliente['email']);
            $ClienteModel->setUsuarioId($Cliente['usuario_id']);

            // Agregar la instancia de Cliente al array
            $ClientesModel[] = $ClienteModel;
        }
        return $ClientesModel;
    }

    public function registroCliente($nombreCliente, $apellidosCliente, $telefonoCliente, $emailCliente, $usuario_id):void {
        $mensaje = 'Regístrate como admin para crear el cliente'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Obtener el email del usuario
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                $nombreCliente = Validacion::saneamientoString($nombreCliente);
                $apellidosCliente = Validacion::saneamientoString($apellidosCliente);
                $telefonoCliente = Validacion::saneartelefono($telefonoCliente);
                $usuario_id = Validacion::sanearNumero($usuario_id);
                if (empty($nombreCliente) || empty($apellidosCliente) || empty($telefonoCliente) || empty($usuario_id) || empty($emailCliente)) {
             
                    // Si el nombre de la categoría está vacío, asignar un mensaje de error
                    $mensaje = "Debe proporcionar todos los campos para el nuevo cliente de forma correcta. Revisa de introducir solo los campos correctos para el teléfono (números con los iconos de + y separadores -)";
                } else {
                    // Guardar la nueva categoría si no está vacía
                     // Intentar guardar el cliente
                    $guardadoExitoso = $this->ClientesService->guardarCliente($nombreCliente, $apellidosCliente, $telefonoCliente, $emailCliente, $usuario_id);

                    // Verificar el resultado y establecer el mensaje correspondiente
                    if ($guardadoExitoso) {
                        $mensaje = "Cliente creado exitosamente.";
                    } else {
                        $mensaje = "Error al crear el cliente. Por favor, inténtelo de nuevo.";
                    }
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevos clientes.";
            }
        }
        
        $this-> mostrarTodos($email, $mensaje);
    }


}
