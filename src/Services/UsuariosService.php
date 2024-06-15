<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    use Models\Usuarios;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
       
        public function register($nombre, $apellidos, $usuario, $email, $contrasena, $rol): ?string {
            // Llama al método del repositorio para insertar el usuario en la base de datos
            return $this->userRepository->registro($nombre, $apellidos, $usuario, $email, $contrasena, $rol);
        }

        //utilizar esta funcion si ciframoscontrasena
        public function verificaCredencialescontrasenacifrada(string $email, string $password): ?Usuarios {
            $user = $this->userRepository->findByemail($email);
            
            // Verifica que el usuario exista y que la contraseña coincida
            if ($user && password_verify($password, $user->getContrasena())) {
            
                return $user; // Devuelve el objeto Usuarios si las credenciales son correctas
            } else {
                return null; // Devuelve null si las credenciales son incorrectas
            }
        }
        //utilizar esta funcion si no ciframos contrasena
        public function verificaCredenciales(string $email, string $password): ?Usuarios {
            $user = $this->userRepository->findByemail($email);
            
            // Verifica que el usuario exista y que la contraseña coincida
            if ($user && $password == $user->getContrasena()) {
            
            // password_verify($password, $user->getContrasena())) {
                return $user; // Devuelve el objeto Usuarios si las credenciales son correctas
            } else {
                return null; // Devuelve null si las credenciales son incorrectas
            }
        }



        public function obtenerUsuarioPorEmail(string $email): ?Usuarios {
            return $this->userRepository->findByEmail($email);
        }        
        
        public function actualizarUsuario(string $nombre, string $apellidos, string $email, string $nuevoRol): ?string {
            return $this->userRepository->actualizarUsuario($nombre, $apellidos, $email, $nuevoRol);
        }

        public function obtenerUsuarios(): ?array {
            return $this->userRepository->obtenerUsuarios();
        }

    }