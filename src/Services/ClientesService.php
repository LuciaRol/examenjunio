<?php
    namespace Services;
    use Repositories\ClientesRepository;
    class ClientesService{
        
        private ClientesRepository $ClientesRepository;
        function __construct() {
            $this->ClientesRepository = new ClientesRepository();
        }

        public function obtenerClientes() :?array {
            return $this->ClientesRepository->findAll();
        }
        
        public function guardarCliente(string $nombreCliente): bool {
            return $this->ClientesRepository->guardarCliente($nombreCliente);
        }
    }