<?php

namespace Controllers;

use Services\ProductosService;
use Lib\Pages;

use Models\Validacion;
class ProductosAPIController
{
    private Pages $pagina;
    private ProductosService $productosService;

    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
        // Crea una instancia del servicio de productos
        $this->productosService = new ProductosService();
        // Crea una instancia del servicio de usuarios
    }

    public function mostrarProductosAPI()
    {
        // Obtener todos los productos
        $productos = $this->productosService->obtenerProductos();

        // Configurar el encabezado para la respuesta JSON
        header('Content-Type: application/json; charset=UTF-8');

        // Convertir el array de productos a formato JSON
        return json_encode($productos);
        
    }
    


}