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
        
        public function guardarCliente(string $nombreCliente): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO clientes_cita (nombre) VALUES (:nombre)");
                $this->sql->bindParam(':nombre', $nombreCliente, PDO::PARAM_STR);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }