<?php

namespace Models;

class Cita
{
    private int $id;
    private string $fecha_hora;
    private ?string $descripcion;
    private int $usuario_id;
    private int $cliente_id;
    private string $fecha_registro;
    private string $nombre_usuario;
    private string $nombre_cliente;

    public function __construct(
        int $id,
        string $fecha_hora,
        ?string $descripcion,
        int $usuario_id,
        int $cliente_id,
        string $fecha_registro,
        string $nombre_usuario,
        string $nombre_cliente,
    ) {
        $this->id = $id;
        $this->fecha_hora = $fecha_hora;
        $this->descripcion = $descripcion;
        $this->usuario_id = $usuario_id;
        $this->cliente_id = $cliente_id;
        $this->fecha_registro = $fecha_registro;
        $this->nombre_usuario = $nombre_usuario;
        $this->nombre_cliente = $nombre_cliente;
    }

    public function getCitaId(): int
    {
        return $this->id;
    }

    public function getFechaHora(): string
    {
        return $this->fecha_hora;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getClienteId(): int
    {
        return $this->cliente_id;
    }

    public function getFechaRegistro(): string
    {
        return $this->fecha_registro;
    }
    

    public function getNombreUsuario(): string
    {
        return $this->nombre_usuario;
    }
    
    public function getNombreCliente(): string
    {
        return $this->nombre_cliente;
    }
    
}
