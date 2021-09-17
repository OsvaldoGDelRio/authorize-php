<?php

namespace src;

use src\excepciones\ElRecursoNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;
use src\excepciones\NoTieneAutorizacionException;
use src\interfaces\VerificarPermisosInterface;

class VerificarPorRecurso implements VerificarPermisosInterface
{
    private array $_datos;

    public function __construct(array $datosPorRol)
    {
        $this->_datos = $this->setDatos($datosPorRol);
    }

    public function verificar(string $rol, string $recursoSolicitado): void
    {
        $this->existeElRecurso($recursoSolicitado);

        if (!in_array($rol, $this->_datos[$recursoSolicitado])) {
            throw new NoTieneAutorizacionException("No tiene autorización");
        }
    }

    public function existeElRecurso(string $recursoSolicitado): void
    {
        if (!array_key_exists($recursoSolicitado, $this->_datos)) {
            throw new ElRecursoNoExisteEnLosDatosDeVerificacionException("El recurso no está especificado en los datos, no se puede verificar");
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
