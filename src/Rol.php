<?php
namespace src;

use src\excepciones\ElRolNoPuedeEstarVacioException;

class Rol
{
    private string $_rol;

    public function __construct(string $rol)
    {
        $this->_rol = $this->setRol($rol);
    }

    public function rol(): string
    {
        return $this->_rol;
    }

    private function setRol(string $string): string
    {
        $this->estaVacio($string);

        return $string;
    }

    private function estaVacio(string $rol): void
    {
        if (empty($rol)) {
            throw new ElRolNoPuedeEstarVacioException("El Rol no puede estar vacío");
        }
    }
}
