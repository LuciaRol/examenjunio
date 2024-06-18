<?php
    namespace Services;
    use Repositories\MedicosRepository;
    class MedicosService{
        
        private MedicosRepository $medicosRepository;
        function __construct() {
            $this->medicosRepository = new MedicosRepository();
        }

        public function obtenermedicos() :?array {
            return $this->medicosRepository->findAll();
        }
        
        public function guardarmedico(string $nombremedico, string  $apellidosmedico, string  $telefonomedico, string  $emailmedico, int $usuario_id): bool {
            return $this->medicosRepository->guardarmedicoRepository($nombremedico, $apellidosmedico, $telefonomedico, $emailmedico, $usuario_id);
        }
    }