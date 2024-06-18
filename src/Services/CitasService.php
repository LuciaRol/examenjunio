<?php
    namespace Services;
    use Repositories\CitasRepository;
    class CitasService{
        
        private CitasRepository $citasRepository;
        function __construct() {
            $this->citasRepository = new citasRepository();
        }

        public function obtenercitas() :?array {
            return $this->citasRepository->findAll();
        }
        
        public function bajarStockcitas(int $cita_id, int $unidades): bool {
            // Crear un nuevo pedido en la base de datos utilizando el repositorio
        
            return $this->citasRepository->bajarStockcitas($cita_id, $unidades);
                                                    
        }
        
        public function guardarcita(string $fecha_hora,string $descripcion,int $usuario_id,int $medico_id, string $fecha_registro): bool {
            return $this->citasRepository->guardarcita($fecha_hora, $descripcion, $usuario_id, $medico_id, $fecha_registro);
        }
        
        public function obtenercitaPorId(int $id): ?array {
            return $this->citasRepository->findById($id);
        }

        public function eliminarcita(int $id): bool {
            return $this->citasRepository->eliminarcita($id);
        }
    
        public function actualizarStock(int $id, int $nuevoStock): bool {
            return $this->citasRepository->updateStock($id, $nuevoStock);
        }

        public function buscarcitas(string $terminoBusqueda): ?array {
            return $this->citasRepository->buscarcitas($terminoBusqueda);
        }
        public function editarcita(int $citaId, string $fecha_hora, string $descripcion, int $usuario_id, int $medico_id): bool {
            return $this->citasRepository->editarcita($citaId, $fecha_hora, $descripcion, $usuario_id, $medico_id
        );
        }
        
    }