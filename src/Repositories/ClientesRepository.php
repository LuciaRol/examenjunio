<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use PDOException;
    use PDO;
    class ClientesRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll(): array|string|null{
            $ClienteCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT *  	                                                               
                                                            FROM clientes_cita");
                
                $this->sql->execute();
                $ClienteCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $ClienteCommit = $ClienteCommitData ?: null;
                
            } catch (PDOException $e) {
                $ClienteCommit = $e->getMessage();
            }
        
            return $ClienteCommit;
        }
        
        public function guardarClienteRepository(string $nombreCliente, string  $apellidosCliente, string  $telefonoCliente, string  $emailCliente, int $usuario_id): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO clientes_cita (nombre, apellidos, telefono, email, usuario_id) VALUES (:nombre, :apellidos, :telefono, :email, :usuario_id )");
                $this->sql->bindParam(':nombre', $nombreCliente, PDO::PARAM_STR);
                $this->sql->bindParam(':apellidos', $apellidosCliente, PDO::PARAM_STR);
                $this->sql->bindParam(':telefono', $telefonoCliente, PDO::PARAM_STR);
                $this->sql->bindParam(':email', $emailCliente, PDO::PARAM_STR);
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }