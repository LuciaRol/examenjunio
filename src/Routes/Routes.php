<?php
   namespace Routes;

   use Controllers\CategoriasController;
   use Controllers\UsuarioController;
   use Controllers\ProductosController;
   use Lib\Router;
   use Controllers\ErrorController;
   use Controllers\WebController;
   use Controllers\LoginController;
   use Controllers\RegistroController;
   use Controllers\CitasController;
   use Controllers\MedicosController;

   use Services\ProductosService;

  class Routes{
    public static function index(){
    /*********************  Bienvenida  ******************************/
    Router::add('GET','/', function () {
            return (new WebController())->mostrarBienvenida();
          });
    
    /*********************  LOGIN  ******************************/
      Router::add('GET','/iniciosesion', function () {
        return (new LoginController())->mostrarLogin();
      });

      Router::add('POST', '/login', function () {
        // Verificar si se ha enviado el formulario de inicio de sesión
        if (isset($_POST['email']) && isset($_POST['password'])) {
            // Obtener el nombre de usuario y la contraseña del formulario
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Crear una instancia del controlador de usuarios
            $loginController = new LoginController();
            // Llamar al método login del controlador de usuarios con el nombre de usuario y la contraseña
            $loginController->login($email, $password);
        }
      });
      
    Router::add('POST','/logout', function (){
        return (new LoginController())->logout();
    }); 


    /*********************  REGISTRO  ******************************/

    Router::add('POST', '/registro_usuario', function () {
        // Verifica si se ha enviado el formulario de registro
        if (isset($_POST['registro'])) {
            // Obtener los datos del formulario
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $usuario = $_POST['usuario'];
            $email = $_POST['email'];
            $contrasena = $_POST['contrasena'];
            
            
            // Llamar al controlador y pasar los datos al método registroUsuario
            $registroController = new RegistroController();
            $registroController->registroUsuario($nombre, $apellidos, $usuario, $email, $contrasena);
        }
    });

    Router::add('GET','/registro', function (){
        return (new RegistroController())->mostrarRegistro();
    });
    
    
    /*********************  USUARIOS  ******************************/

    Router::add('GET','/usuario', function () {
        return (new UsuarioController())->mostrarUsuario();
    });

    Router::add('POST', '/edita_perfil', function () {
        // Check if the form for updating the user profile has been submitted
        if (isset($_POST['new_nombre']) && isset($_POST['new_apellidos']) && isset($_POST['new_rol']) && isset($_POST['new_email'])) {
            // Get the data from the form
            $nombre = $_POST['new_nombre'];
            $apellidos = $_POST['new_apellidos'];
            $email = $_POST['new_email'];
            $rol = $_POST['new_rol'];
            
            // Create an instance of the UsuarioController
            $usuariosController = new UsuarioController();
            // Call the actualizarUsuario method of the UsuarioController with the form data
            $usuariosController->actualizarUsuario($nombre, $apellidos, $email, $rol);
        }
    });

    Router::add('POST', '/borrar_usuario', function () {
        // Verifica si se ha enviado el formulario para borrar el usuario
        if (isset($_POST['usuario_id'])) {
            $usuario_id = $_POST['usuario_id'];
            
            // Crear una instancia del controlador de usuarios
            $usuariosController = new UsuarioController();
            
            // Llama al método para borrar usuario del controlador de usuarios
            $usuariosController->borrarUsuario($usuario_id);
        }
    });



    /********************* CATEGORIAS  ******************************/

        
    Router::add('GET','/categorias', function () {
        return (new CategoriasController())->mostrarTodos();
    });

    Router::add('POST', '/registro_categoria', function () {
        // Verificar si se ha enviado el formulario para registrar una nueva categoría
        if (isset($_POST['nueva_categoria'])) {
            // Obtener el nombre de la nueva categoría desde el formulario
            $nombreCategoria = $_POST['nueva_categoria'];
            
            // Crear una instancia del controlador de categorías
            $categoriasController = new CategoriasController();
            
            // Llamar al método para registrar una nueva categoría del controlador de categorías
            $categoriasController->registroCategoria($nombreCategoria);
        }
    });


    /********************* CITAS  ******************************/


    Router::add('GET','/citas', function (){
        return (new CitasController())->mostrarCitas();
    });

    Router::add('POST', '/eliminar_cita', function () {
        // Verificar si se ha enviado el formulario para eliminar un producto del carrito
        if (isset($_POST['cita_id'])) {
            // Obtener el ID del producto desde el formulario
            $cita_id = $_POST['cita_id'];
            
            // Llamar al método eliminarDelCarrito del controlador CarritoController
            return (new CitasController())->eliminarCita($cita_id);
        }
    });

    Router::add('POST', '/nueva_cita', function () {
        // Verificar si se ha enviado el formulario para crear una nueva cita
        if (isset($_POST['fecha_hora'], $_POST['descripcion'], $_POST['usuario_id'], $_POST['cliente'])) {
            // Obtener la información del formulario
            $fecha_hora = $_POST['fecha_hora'];
            $descripcion = $_POST['descripcion'];
            $usuario_id = $_POST['usuario_id'];
            $cliente_id = $_POST['cliente'];
    
            // Llamar a la función para registrar la nueva cita
            return (new CitasController())->registrocita($fecha_hora, $descripcion, $usuario_id, $cliente_id);
        }
    });

    Router::add('POST', '/editar_cita', function () {
        // Verificar si se ha enviado el formulario para editar una cita
        if (isset($_POST['cita_id'], $_POST['fecha_hora'], $_POST['descripcion'], $_POST['usuario_id'], $_POST['cliente_id'])) {
            // Obtener la información del formulario
            $citaId = $_POST['cita_id'];
            $fecha_hora = $_POST['fecha_hora'];
            $descripcion = $_POST['descripcion'];
            $usuario_id = $_POST['usuario_id'];
            $cliente_id = $_POST['cliente_id'];
            
            // Validar los datos antes de continuar
            // Aquí deberías incluir validaciones adicionales según tus requisitos
    
            // Llamar a la función para editar la cita
            return (new CitasController())->editarCita($citaId, $fecha_hora, $descripcion, $usuario_id, $cliente_id);
        } else {
            // Enviar una respuesta de error si faltan datos en el formulario
            http_response_code(400); // Bad Request
            echo "Error: Faltan datos en el formulario de edición de cita.";
            exit();
        }
    });
    
    /********************* MÉDICOS  ******************************/

    Router::add('GET','/medicos', function () {
        return (new MedicosController())->mostrarTodos();
    });

    Router::add('POST', '/registro_medico', function () {
        // Verificar si se ha enviado el formulario para registrar un nuevo medico
        if (isset($_POST['nombre_medico'], $_POST['apellidos_medico'], $_POST['telefono_medico'], $_POST['email_medico'], $_POST['usuario_id'])) {
            // Obtener los datos del formulario
            $nombremedico = $_POST['nombre_medico'];
            $apellidosmedico = $_POST['apellidos_medico'];
            $telefonomedico = $_POST['telefono_medico'];
            $emailmedico = $_POST['email_medico'];
            $usuario_id = $_POST['usuario_id'];
            
            // Crear una instancia del controlador de medicos
            $medicosController = new MedicosController();
            
            // Llamar al método para registrar un nuevo medico del controlador de medicos
            $medicosController->registromedico($nombremedico, $apellidosmedico, $telefonomedico, $emailmedico, $usuario_id);
        } else {
            // Enviar una respuesta de error si faltan datos en el formulario
            http_response_code(400); // Bad Request
            echo "Error: Faltan datos en el formulario de registro de medico.";
            exit();
        }
    });
    


    /********************* SERVICIOS  ******************************/


    Router::add('GET','/productos', function (){
        return (new ProductosController())->mostrarProductos();
    });

    Router::add('POST', '/eliminar_producto', function () {
        // Verificar si se ha enviado el formulario para eliminar un producto del carrito
        if (isset($_POST['producto_id'])) {
            // Obtener el ID del producto desde el formulario
            $productoId = $_POST['producto_id'];
            
            // Llamar al método eliminarDelCarrito del controlador CarritoController
            return (new ProductosController())->eliminarProducto($productoId);
        }
    });

    Router::add('POST', '/nuevo_producto', function () {
        // Verificar si se ha enviado el formulario para crear un nuevo producto
        if (isset($_POST['nuevo_producto'], $_POST['descripcion'], $_POST['precio'], $_POST['categoria'])) {
            // Obtener la información del formulario
            $nombreProducto = $_POST['nuevo_producto'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoria_id = $_POST['categoria'];
            
            // Llamar a la función para registrar el nuevo producto
            return (new ProductosController())->registroProducto($categoria_id, $nombreProducto, $descripcion, $precio);
        }
    });


    Router::add('POST', '/editar_producto', function () {
        // Verificar si se ha enviado el formulario para editar un producto
        if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'])) {
            // Obtener la información del formulario
            $productoId = $_POST['producto_id'];
            $nombreProducto = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = floatval($_POST['precio']); // Convertir a float
            $categoria_id = $_POST['categoria_id'];
    
    
            // Llamar a la función para editar el producto
            return (new ProductosController())->editarProducto($productoId, $categoria_id, $nombreProducto, $descripcion, $precio);
        } else {
            // Enviar una respuesta de error si faltan datos en el formulario
            http_response_code(400); // Bad Request
            echo "Error: Faltan datos en el formulario de edición.";
            exit();
        }
    });
    
    /********************* PEDIDOS  ******************************/



   
    /********************* CARRITO  ******************************/
                
    
        

   
    /********************* BÚSQUEDA  ******************************/

    Router::add('POST', '/busqueda', function () {
            if (isset($_POST['q'])) {
                $terminoBusqueda = trim($_POST['q']);
                return (new ProductosController())->buscarProductos($terminoBusqueda);
            }
        });

    /********************* API  ******************************/

    

    /********************* ERROR  ******************************/

    Router::add('GET','/error', function (){
        /* return (new ErrorController())->show_error404(); */
        return "ERROR";
    });

        
        
        Router::dispatch();
    }
  }