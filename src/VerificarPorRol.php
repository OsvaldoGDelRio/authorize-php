<?php

namespace src;

use src\excepciones\ElRolNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;
use src\excepciones\NoTieneAutorizacionException;
use src\interfaces\VerificarPermisosInterface;

class VerificarPorRol implements VerificarPermisosInterface
{
    private array $_datos;

    public function __construct(array $datosPorRol)
    {
        $this->_datos = $this->setDatos($datosPorRol);
    }

    public function verificar(string $rol, string $recursoSolicitado): void
    {
        $this->existeElRol($rol);

        if (!in_array($recursoSolicitado, $this->_datos[$rol])) {
            throw new NoTieneAutorizacionException("No tiene autorización");
        }
    }

    public function existeElRol(string $rol): void
    {
        if (!array_key_exists($rol, $this->_datos)) {
            throw new ElRolNoExisteEnLosDatosDeVerificacionException("El rol no está especificado en los datos, no se puede verificar");
        }
    }

    private function setDatos(array $array): array
    {
        if (count($array) == 0) {
            throw new LosDatosParaVerificarAutorizacionEstanVaciosException("Los datos para verificar si existe autorización están vacíos", 1);
        }

        return $array;
    }
}
