<?php
namespace src;

use src\excepciones\RecursoSolicitadoVacioException;

use src\interfaces\VerificarPermisosInterface;

class Autorizacion
{
    private Rol $_rol;
    private string $_recursoSolicitado;

    public function __construct(
        VerificarPermisosInterface $verificarPermisosInterface,
        Rol $rol,
        string $recursoSolicitado
    ) {
        $this->_rol = $rol;
        
        $this->_recursoSolicitado = $this->setRecursoSolicitado($recursoSolicitado);

        $verificarPermisosInterface->verificar($this->_rol->rol(), $this->_recursoSolicitado);
    }

    public function rol(): string
    {
        return $this->_rol->rol();
    }

    public function recursoSolicitado(): string
    {
        return $this->_recursoSolicitado;
    }

    private function setRecursoSolicitado(string $string): string
    {
        if (empty($string)) {
            throw new RecursoSolicitadoVacioException("El recurso que se solicita no puede estar vacío");
        }

        return $string;
    }
}
