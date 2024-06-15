<?php
    namespace Services;
    use Repositories\citasRepository;
    class citasService{
        
        private citasRepository $citasRepository;
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
        
        public function guardarcita(int $categoria_id, string $nombrecita, string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha, string $imagen): bool {
            return $this->citasRepository->guardarcita($categoria_id, $nombrecita, $descripcion, $precio, $stock, $oferta, $fecha, $imagen);
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

        public function editarcita(int $citaId, int $categoria_id, string $nombrecita, string $descripcion, float $precio, int $stock, ?string $oferta, string $fecha): bool {
            return $this->citasRepository->editarcita($citaId, $categoria_id, $nombrecita, $descripcion, $precio, $stock, $oferta, $fecha);
        }
        
    }