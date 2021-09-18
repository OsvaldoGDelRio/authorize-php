<?php

namespace src;

use src\excepciones\ElRecursoNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\NoTieneAutorizacionException;
use src\interfaces\VerificarPermisosInterface;
use src\DatosDeConfiguracion;

class VerificarPorRecurso implements VerificarPermisosInterface
{
    private array $_datos;

    public function __construct(DatosDeConfiguracion $datosPorRol)
    {
        $this->_datos = $datosPorRol->datos();
    }

    public function verificar(string $rol, string $recursoSolicitado): void
    {
        $this->existeElRecurso($recursoSolicitado);
        
        if (!in_array($rol, $this->_datos[$recursoSolicitado])) {
            throw new NoTieneAutorizacionException("No tiene autorización");
        }
    }

    private function existeElRecurso(string $recursoSolicitado): void
    {
        if (!array_key_exists($recursoSolicitado, $this->_datos)) {
            throw new ElRecursoNoExisteEnLosDatosDeVerificacionException("El recurso no está especificado en los datos, no se puede verificar");
        }
    }
}
