<?php

namespace Models;

class Medico {

    private $id;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $email;
    private $usuario_id;
    
    // Getters and Setters for each property

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }
}
