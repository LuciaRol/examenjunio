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
        
        public function guardarCliente(string $nombreCliente, string  $apellidosCliente, string  $telefonoCliente, string  $emailCliente, int $usuario_id): bool {
            return $this->ClientesRepository->guardarClienteRepository($nombreCliente, $apellidosCliente, $telefonoCliente, $emailCliente, $usuario_id);
        }
    }