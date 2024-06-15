<?php

namespace Controllers;

use Services\citasService;
use Lib\Pages;
use Models\cita;
use Services\UsuariosService;
use Models\Validacion;
class citasController
{
    private Pages $pagina;
    private citasService $citasService;
    private UsuariosService $usuariosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de citas
        $this->citasService = new citasService();
        // Crea una instancia del servicio de usuarios
        $this->usuariosService = new UsuariosService();
    }

    public function mostrarcitas($emailRecordado = null, $mensaje = null): void
    {
        // Obtener todos los citas
        $citas = $this->citasService->obtenercitas();

        // Crear un array para almacenar los objetos de cita
        $citasModel = [];
        foreach ($citas as $cita) {
            // Crear una nueva instancia de cita con los datos del cita
            $citaModel = new Cita(
                $cita['cita_id'],
                $cita['fecha_hora'],
                $cita['descripcion'],
                $cita['usuario_id'],
                $cita['cliente_id'],
                $cita['fecha_registro'],
                $cita['nombre_usuario'],
                $cita['nombre_cliente']
            );
            // Agregar la instancia de cita al array
            $citasModel[] = $citaModel;

        }

        // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario($emailRecordado);
        // Verifica si el usuario está autenticado
        $rol = 'usur';
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            // Verifica si el usuario tiene permisos de administrador
            $rol = $email->getRol();
            }
       
        // Devolver la renderización de la página con los objetos de cita y el correo electrónico de la sesión
        $this->pagina->render('citas/mostrarcitas', ['citas' => $citasModel, 'emailSesion' => $emailSesion, 'rol' => $rol, 'mensaje' => $mensaje]);
    }


    

    public function registrocita($categoria_id, $nombrecita, $descripcion, $precio, $stock, $oferta, $fecha, $imagen): void {
        $mensaje = 'Regístrate como admin para crear un cita'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                // Sanea los datos del cita
                $nombrecita = Validacion::sanearString($nombrecita);
                $descripcion = Validacion::sanearString($descripcion);
                $precio = Validacion::sanearNumero($precio);
                $stock = Validacion::sanearNumero($stock);
                $oferta = Validacion::sanearString($oferta);
    
                // Validar campos obligatorios
                if (empty($nombrecita) || empty($categoria_id) || empty($precio) || empty($stock) || empty($fecha)) {
                    $mensaje = "Debe proporcionar todos los campos obligatorios.";
                } else {
                    // Guardar el nuevo cita
                    
                    $this->citasService->guardarcita($categoria_id, $nombrecita, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);
                    $mensaje = "cita creado exitosamente.";
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para registrar nuevos citas.";
            }
        }
    
        $this->mostrarcitas($email, $mensaje);
    }

    public function editarcita($citaId, $categoria_id, $nombrecita, $descripcion, $precio, $stock, $oferta, $fecha): void {
        $mensaje = 'Regístrate como admin para editar un cita'; // Inicializamos la variable de mensaje
        
        $usuarioController = new UsuarioController();
        // Verifica si el usuario está autenticado
        if ($usuarioController->sesion_usuario()) {
            // Obtén el usuario actual
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                // Sanea los datos del cita
                $nombrecita = Validacion::sanearString($nombrecita);
                $descripcion = Validacion::sanearString($descripcion);
                $precio = Validacion::sanearNumero($precio);
                $stock = Validacion::sanearNumero($stock);
                $oferta = Validacion::sanearString($oferta);
    
                // Validar campos obligatorios
                if (empty($nombrecita) || empty($categoria_id) || empty($precio) || empty($stock) || empty($fecha)) {
                    $mensaje = "Debe proporcionar todos los campos obligatorios.";
                } else {
                    // Editar el cita existente
                    
                    $this->citasService->editarcita($citaId, $categoria_id, $nombrecita, $descripcion, $precio, $stock, $oferta, $fecha);
                    $mensaje = "cita actualizado exitosamente.";
                }
            } else {
                // Si el usuario no es administrador, asigna un mensaje indicando que no tiene permisos suficientes
                $mensaje = "No tienes permisos de administrador para editar citas.";
            }
        }
    
        $this->mostrarcitas($email, $mensaje);
    }
    
   
public function eliminarcita($cita_id, $emailRecordado = null): void {   
        $mensaje = 'Tienes que ser admin para borrar un cita'; // Inicializamos la variable de mensaje

        $usuarioController = new UsuarioController();
        if ($usuarioController->sesion_usuario()) {
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            
            // Verifica si el usuario tiene permisos de administrador
            if ($email->getRol() === 'admin') {
                $this->citasService->eliminarcita($cita_id);
                $mensaje = "cita borrado exitosamente.";


                // Mostrar el carrito después de eliminar el cita
                $this->mostrarcitas($email, $mensaje);
            }
            else {
                $this->mostrarcitas(null, $mensaje);
            }
        }
        else {
            $this->mostrarcitas(null, $mensaje);

        }
}

public function buscarcitas($terminoBusqueda): void
    {
        // Sanear el término de búsqueda
        $terminoBusqueda = Validacion::sanearString($terminoBusqueda);

        // Llamar al servicio de citas para buscar citas
        $citas = $this->citasService->buscarcitas($terminoBusqueda);

        // Crear un array para almacenar los objetos de cita
        $citasModel = [];
        foreach ($citas as $cita) {
            $citaModel = new cita(
                $cita['cita_id'],
                $cita['fecha_hora'],
                $cita['descripcion'],
                $cita['usuario_id'],
                $cita['cliente_id'],
                $cita['fecha_registro'],
                $cita['nombre_usuario'],
                $cita['nombre_cliente']
            );
            $citasModel[] = $citaModel;
        }

        // Obtener el email del usuario
        $usuarioController = new UsuarioController();
        $emailSesion = $usuarioController->obtenerEmailUsuario(null);

        // Verifica si el usuario está autenticado
        $rol = 'usur';
        if ($usuarioController->sesion_usuario()) {
            $email = $this->usuariosService->obtenerUsuarioPorEmail($_SESSION['email']);
            $rol = $email->getRol();
        }

        // Devolver la renderización de la página con los resultados de búsqueda
        $this->pagina->render('citas/mostrarcitas', ['citas' => $citasModel, 'emailSesion' => $emailSesion, 'rol' => $rol, 'terminoBusqueda' => $terminoBusqueda]);
    }
}