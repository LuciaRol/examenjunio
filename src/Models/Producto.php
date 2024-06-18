<?php

namespace Models;

class Producto
{
    private int $id;
    private int $categoria_id;
    private string $nombre;
    private ?string $descripcion;
    private float $precio;

    public function __construct(
        int $id,
        int $categoria_id,
        string $nombre,
        ?string $descripcion,
        float $precio
    ) {
        $this->id = $id;
        $this->categoria_id = $categoria_id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoriaId(): int
    {
        return $this->categoria_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

   public function setId(int $id): void {
    $this->id = $id;
    }

    public function setCategoriaId(int $categoria_id): void {
        $this->categoria_id = $categoria_id;
    }

	public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

	public function setPrecio(float $precio): void {
        $this->precio = $precio;
    }

	

    
}
