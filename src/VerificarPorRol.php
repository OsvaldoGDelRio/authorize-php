<?php

namespace src;

use src\excepciones\ElRolNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;
use src\excepciones\NoTieneAutorizacionException;
use src\interfaces\VerificarPermisosInterface;

class VerificarPorRol implements VerificarPermisosInterface
{
    private array $_datos;

    public function __construct(DatosDeConfiguracion $datosPorRol)
    {
        $this->_datos = $datosPorRol->datos();
    }

    public function verificar(string $rol, string $recursoSolicitado): void
    {
        $this->existeElRol($rol);

        if (!in_array($recursoSolicitado, $this->_datos[$rol])) {
            throw new NoTieneAutorizacionException("No tiene autorización");
        }
    }

    private function existeElRol(string $rol): void
    {
        if (!array_key_exists($rol, $this->_datos)) {
            throw new ElRolNoExisteEnLosDatosDeVerificacionException("El rol no está especificado en los datos, no se puede verificar");
        }
    }
}
