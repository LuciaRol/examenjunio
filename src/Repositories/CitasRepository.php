<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Blog;
    use Models\Validacion;
    use Models\cita;
    use PDOException;
    use PDO;
    class citasRepository{
        private DataBase $conexion;
        private mixed $sql;
        function __construct(){
            $this->conexion = new DataBase();
        }
        public function findAll():array|string|null {
            $citaCommit = null;
            try {
                $this->sql = $this->conexion->prepareSQL("
                                                        SELECT  c.id, 
                                                                c.fecha_hora, 
                                                                c.descripcion, 
                                                                c.usuario_id,
                                                                c.cliente_id,
                                                                c.fecha_registro,
                                                                u.nombre AS nombre_usuario, 
                                                                cc.nombre AS nombre_cliente
                                                        FROM citas c
                                                        JOIN usuarios u 
                                                            ON c.usuario_id = u.id
                                                        JOIN clientes_cita cc 
                                                            ON c.cliente_id = cc.id;");



                
                $this->sql->execute();
                $citaCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $citaCommit = $citaCommitData ?: null;
                
            } catch (PDOException $e) {
                $citaCommit = $e->getMessage();
            }
        
            return $citaCommit;
        }
        
        public function guardarcita(string $fecha_hora,string $descripcion,int $usuario_id,int $cliente_id, string $fecha_registro): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("INSERT INTO citas (fecha_hora, descripcion, usuario_id, cliente_id, fecha_registro) 
                                                        VALUES (:fecha_hora, :descripcion, :usuario_id, :cliente_id, :fecha_registro)");
                $this->sql->bindParam(':fecha_hora', $fecha_hora, PDO::PARAM_STR);
                $this->sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $this->sql->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
                $this->sql->bindParam(':fecha_registro', $fecha_registro, PDO::PARAM_STR);

                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        public function editarcita(int $citaId, int $categoria_id, string $nombre, ?string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("UPDATE citas SET 
                                                            categoria_id = :categoria_id, 
                                                            nombre = :nombre, 
                                                            descripcion = :descripcion, 
                                                            precio = :precio, 
                                                            stock = :stock, 
                                                            oferta = :oferta, 
                                                            fecha = :fecha
                                                        WHERE id = :citaId");
                $this->sql->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
                $this->sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $this->sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->bindParam(':precio', $precio, PDO::PARAM_STR);
                $this->sql->bindParam(':stock', $stock, PDO::PARAM_INT);
                $this->sql->bindParam(':oferta', $oferta, PDO::PARAM_STR);
                $this->sql->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                
                $this->sql->bindParam(':citaId', $citaId, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        
        public function bajarStockcitas(int $citaId, int $unidades): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("
                                                            UPDATE citas SET 
                                                                stock = stock - :unidades 
                                                            WHERE id = :citaId
                                                        ");
                $this->sql->bindParam(':unidades', $unidades, PDO::PARAM_INT);
                $this->sql->bindParam(':citaId', $citaId, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        

        public function findById(int $id): ?array {
            try {
                $this->sql = $this->conexion->prepareSQL("SELECT * FROM citas WHERE id = :id");
                $this->sql->bindParam(':id', $id, PDO::PARAM_INT);
                $this->sql->execute();
                $cita = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                return $cita ?: null;
            } catch (PDOException $e) {
                return null;
            }
        }
    
        public function updateStock(int $id, int $nuevoStock): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("UPDATE citas SET stock = :stock WHERE id = :id");
                $this->sql->bindParam(':stock', $nuevoStock, PDO::PARAM_INT);
                $this->sql->bindParam(':id', $id, PDO::PARAM_INT);
                $this->sql->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        public function eliminarcita(int $id): bool {
            try {
                $this->sql = $this->conexion->prepareSQL("DELETE FROM citas WHERE id = :id");
                $this->sql->bindParam(':id', $id, PDO::PARAM_INT);
                $this->sql->execute();
                
                // Verificar si se eliminó correctamente el cita
                return true;
                
            } catch (PDOException $e) {
                // Manejar la excepción si ocurre algún error durante la ejecución de la consulta
                return false;
            }
        }

        
        
        public function buscarcitas($descripcion):array|string|null {
            $citaCommit = null;
            try {

                $descripcion = strtolower($descripcion);
                $descripcion = '%' . $descripcion . '%';
                $this->sql = $this->conexion->prepareSQL("SELECT    a.id, 
                                                            a.categoria_id, 
                                                            a.nombre, 
                                                            a.descripcion, 
                                                            a.precio, 
                                                            a.stock, 
                                                            a.oferta, 
                                                            a.fecha, 
                                                            a.imagen, 
                                                            b.nombre as 'categoria' 
                                                    FROM citas a inner join categorias b on a.categoria_id = b.id
                                                    where LOWER(a.descripcion) like :descripcion or LOWER(a.nombre) like :descripcion or LOWER(b.nombre) like :descripcion");
                $this->sql->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
                $this->sql->execute();
                $citaCommitData = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $citaCommit = $citaCommitData ?: null;
                
            } catch (PDOException $e) {
                $citaCommit = $e->getMessage();
            }
        
            return $citaCommit;
        }
        
        








}