<?php
   namespace Routes;

   use Controllers\CategoriasController;
   use Controllers\UsuarioController;
   use Controllers\PedidosController;
   use Controllers\ProductosController;
   use Controllers\CarritoController;
   use Lib\Router;
   use Controllers\ErrorController;
   use Controllers\WebController;
   use Controllers\LoginController;
   use Controllers\RegistroController;
   use Controllers\ProductosAPIController;
   use Controllers\CitasController;
   use Controllers\ClientesController;

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
        /* if (isset($_POST['email']) && isset($_POST['password'])) { */
            if (isset($_POST['usuario']) && isset($_POST['password'])) {
            // Obtener el nombre de usuario y la contraseña del formulario
            //$email = $_POST['email'];
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
    
            // Crear una instancia del controlador de usuarios
            $LoginController = new LoginController();
            // Llamar al método login del controlador de usuarios con el nombre de usuario y la contraseña
            $LoginController->login($usuario, $password);
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
    
    /********************* CLIENTES CITA  ******************************/

    Router::add('GET','/clientes', function () {
        return (new clientesController())->mostrarTodos();
    });

    Router::add('POST', '/registro_cliente', function () {
        // Verificar si se ha enviado el formulario para registrar un nuevo cliente
        if (isset($_POST['nombre_cliente'], $_POST['apellidos_cliente'], $_POST['telefono_cliente'], $_POST['email_cliente'], $_POST['usuario_id'])) {
            // Obtener los datos del formulario
            $nombreCliente = $_POST['nombre_cliente'];
            $apellidosCliente = $_POST['apellidos_cliente'];
            $telefonoCliente = $_POST['telefono_cliente'];
            $emailCliente = $_POST['email_cliente'];
            $usuario_id = $_POST['usuario_id'];
            
            // Crear una instancia del controlador de clientes
            $clientesController = new ClientesController();
            
            // Llamar al método para registrar un nuevo cliente del controlador de clientes
            $clientesController->registroCliente($nombreCliente, $apellidosCliente, $telefonoCliente, $emailCliente, $usuario_id);
        } else {
            // Enviar una respuesta de error si faltan datos en el formulario
            http_response_code(400); // Bad Request
            echo "Error: Faltan datos en el formulario de registro de cliente.";
            exit();
        }
    });
    


    /********************* PRODUCTOS  ******************************/


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
        if (isset($_POST['nuevo_producto'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'], $_POST['categoria'])) {
            // Obtener la información del formulario
            $nombreProducto = $_POST['nuevo_producto'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $fecha = $_POST['fecha'];
            $categoria_id = $_POST['categoria'];
            $imagen = $_POST['imagen'];
            
            // Llamar a la función para registrar el nuevo producto
            return (new ProductosController())->registroProducto($categoria_id, $nombreProducto, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);
        }
    });


    Router::add('POST', '/editar_producto', function () {
        // Verificar si se ha enviado el formulario para editar un producto
        if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            // Obtener la información del formulario
            $productoId = $_POST['producto_id'];
            $nombreProducto = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = floatval($_POST['precio']); // Convertir a float
            $stock = intval($_POST['stock']); // Convertir a int
            $oferta = $_POST['oferta'];
            $fecha = $_POST['fecha'];
          
            $categoria_id = $_POST['categoria_id'];
    
            // Validar los datos antes de continuar
            // Aquí deberías incluir validaciones adicionales según tus requisitos
    
            // Llamar a la función para editar el producto
            return (new ProductosController())->editarProducto($productoId, $categoria_id, $nombreProducto, $descripcion, $precio, $stock, $oferta, $fecha);
        } else {
            // Enviar una respuesta de error si faltan datos en el formulario
            http_response_code(400); // Bad Request
            echo "Error: Faltan datos en el formulario de edición.";
            exit();
        }
    });
    
    /********************* PEDIDOS  ******************************/



    Router::add('GET','/pedidos', function (){
        return (new PedidosController())->mostrarPedidos();
    }); 
    
    // Esta función está disponible solo para rol admin
    Router::add('POST', '/cambioestadopedido', function () {
        // Verificar si se ha enviado el formulario para cambiar el estado del pedido
        if (isset($_POST['pedido_id']) && isset($_POST['nuevo_estado'])) {
            // Obtener la información del formulario
            $pedido_id = $_POST['pedido_id'];
            $nuevo_estado = $_POST['nuevo_estado'];
            
            // Llamar a la función para cambiar el estado del pedido pasando los parámetros necesarios
            return (new PedidosController())->nuevoestado($pedido_id, $nuevo_estado);
        }
    });
       
    /********************* CARRITO  ******************************/
                
    Router::add('GET','/carrito', function (){
        return (new CarritoController())->mostrarCarrito();
    });
    

    Router::add('POST', '/agregar_al_carrito', function () {
        // Verificar si se ha enviado el formulario para agregar un producto al carrito
        if (isset($_POST['producto_id'], $_POST['cantidad'])) {
            // Obtener el ID del producto desde el formulario
            $productoId = $_POST['producto_id'];
            $cantidad = $_POST['cantidad'];
            return (new CarritoController())->agregarAlCarrito($productoId, $cantidad);
            
        }
    });
    
       
    Router::add('POST', '/eliminar_producto_carrito', function () {
        // Verificar si se ha enviado el formulario para eliminar un producto del carrito
        if (isset($_POST['producto_key'])) {
            // Obtener el ID del producto desde el formulario
            $productoId = $_POST['producto_key'];
            
            // Llamar al método eliminarDelCarrito del controlador CarritoController
            return (new CarritoController())->eliminarDelCarrito($productoId);
        }
    });
        

    Router::add('POST', '/comprar_carrito', function () {
        // Verificar si se ha enviado el formulario para comprar el carrito
        if (isset($_POST['provincia'], $_POST['localidad'], $_POST['direccion'])) {
            // Obtener la información del formulario
            $provincia = $_POST['provincia'];
            $localidad = $_POST['localidad'];
            $direccion = $_POST['direccion'];
            
            // Calcular el coste total sumando los precios de los productos en el carrito
            
            // Llamar a la función comprar pasando los parámetros necesarios
            return (new CarritoController())->comprar($provincia, $localidad, $direccion);
        }
    });

    /********************* BÚSQUEDA  ******************************/

    Router::add('POST', '/busqueda', function () {
            if (isset($_POST['q'])) {
                $terminoBusqueda = trim($_POST['q']);
                return (new ProductosController())->buscarProductos($terminoBusqueda);
            }
        });

    /********************* API  ******************************/

    Router::add('GET', '/api_producto', function () {
        return (new ProductosAPIController())->mostrarProductosAPI();
    });

    /********************* ERROR  ******************************/

    Router::add('GET','/error', function (){
        /* return (new ErrorController())->show_error404(); */
        return "ERROR";
    });

        
        
        Router::dispatch();
    }
  }