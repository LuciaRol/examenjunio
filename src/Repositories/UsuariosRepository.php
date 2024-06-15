<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Usuarios;
    use DateTime;
    use PDOException;
    use PDO;
    class UsuariosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        
        public function registro_cifrado($nombre, $apellidos, $usuario, $email, $contrasena, $rol): ?string {
            try {
                // Cifra la contraseña
                $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
                // Prepara y ejecuta la consulta SQL para insertar el usuario en la base de datos
                $this->sql = $this->conexion->prepareSQL("INSERT INTO usuarios (nombre, apellidos, usuario, email, contrasena, rol) VALUES (:nombre, :apellidos, :usuario, :email, :contrasena, :rol);");
                $this->sql->bindValue(":nombre", "$nombre", PDO::PARAM_STR);
                $this->sql->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":usuario", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":email", $email, PDO::PARAM_STR);
                $this->sql->bindValue(":contrasena", $contrasena, PDO::PARAM_STR); // Guarda la contraseña cifrada
                $this->sql->bindValue(":rol", $rol, PDO::PARAM_STR);
                $this->sql->execute();
                $this->sql->closeCursor();
                $resultado = null;
            } catch (PDOException $e) {
                $resultado = $e->getMessage();
            }
            return $resultado;
        }
        
        public function registro($nombre, $apellidos, $usuario, $email, $contrasena, $rol): ?string {
            try {
                // Cifra la contraseña
                //$contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
                // Prepara y ejecuta la consulta SQL para insertar el usuario en la base de datos
                $this->sql = $this->conexion->prepareSQL("INSERT INTO usuarios (nombre, apellidos, usuario, email, contrasena, rol) VALUES (:nombre, :apellidos, :usuario, :email, :contrasena, :rol);");
                $this->sql->bindValue(":nombre", "$nombre", PDO::PARAM_STR);
                $this->sql->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":usuario", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":email", $email, PDO::PARAM_STR);
                $this->sql->bindValue(":contrasena", $contrasena, PDO::PARAM_STR); // Guarda la contraseña cifrada
                $this->sql->bindValue(":rol", $rol, PDO::PARAM_STR);
                $this->sql->execute();
                $this->sql->closeCursor();
                $resultado = null;
            } catch (PDOException $e) {
                $resultado = $e->getMessage();
            }
            return $resultado;
        }

        public function borrarUsuario(int $usuario_id): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("DELETE FROM usuarios WHERE id = :usuario_id");
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->execute();
                
                // Verificar si se eliminó correctamente el producto
                return true;
                
            } catch (PDOException $e) {
                // Manejar la excepción si ocurre algún error durante la ejecución de la consulta
                return false;
            }
        }

        public function findByemail(string $email): ?Usuarios {
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT * FROM usuarios WHERE email = :email LIMIT 1;");
                $this->sql->bindValue(":email", $email, PDO::PARAM_STR);
                $this->sql->execute();
                // Obtén los datos como un array asociativo
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                
                $this->sql->closeCursor();
                
                // Verifica si se encontró un usuario
                if ($usuarioData) {
                    // Crea un objeto Usuarios utilizando los datos recuperados
                    $usuario = new Usuarios(
                        $usuarioData['id'],
                        $usuarioData['nombre'],
                        $usuarioData['apellidos'],
                        $usuarioData['usuario'],
                        $usuarioData['email'],
                        $usuarioData['contrasena'],
                        $usuarioData['rol']
                    );
                    return $usuario; // Devuelve el objeto Usuarios si se encontró el usuario
                } else {
                    return null; // Devuelve null si no se encontró el usuario
                }
            } catch (PDOException $e) {
                return null; // Devuelve null en caso de error
            }
        }

        public function actualizarUsuario(string $nombre, string $apellidos, string $email, string $nuevoRol): ?string {
            try {
                // Esta query actualiza el usuario. Cambiar email por usuario dependiendo de cual sea el campo clave de cada apliación
                $this->sql = $this->conexion->prepareSQL("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, rol = :rol WHERE email = :email");
                $this->sql->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $this->sql->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $this->sql->bindValue(":email", $email, PDO::PARAM_STR);
                $this->sql->bindValue(":rol", $nuevoRol, PDO::PARAM_STR);
                $this->sql->execute();
                $this->sql->closeCursor();
                return null;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public function obtenerUsuarios() {
            $usuarioData = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT * FROM usuarios");
                
                $this->sql->execute();
                $usuarioData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuarioCommit = $usuarioData ?: null;
                
            } catch (PDOException $e) {
                $usuarioCommit = $e->getMessage();
            }
        
            return $usuarioCommit;
        }

       
        
    }