<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use PDOException;
    use PDO;
    class MedicosRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll(): array|string|null{
            $medicoCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT *  	                                                               
                                                            FROM medicos");
                
                $this->sql->execute();
                $medicoCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $medicoCommit = $medicoCommitData ?: null;
                
            } catch (PDOException $e) {
                $medicoCommit = $e->getMessage();
            }
        
            return $medicoCommit;
        }
        
        public function guardarmedicoRepository(string $nombremedico, string  $apellidosmedico, string  $telefonomedico, string  $emailmedico, int $usuario_id): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO medicos (nombre, apellidos, telefono, email, usuario_id) VALUES (:nombre, :apellidos, :telefono, :email, :usuario_id )");
                $this->sql->bindParam(':nombre', $nombremedico, PDO::PARAM_STR);
                $this->sql->bindParam(':apellidos', $apellidosmedico, PDO::PARAM_STR);
                $this->sql->bindParam(':telefono', $telefonomedico, PDO::PARAM_STR);
                $this->sql->bindParam(':email', $emailmedico, PDO::PARAM_STR);
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        
    }