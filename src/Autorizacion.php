<?php
namespace src;

use src\interfaces\VerificarPermisosInterface;
use src\RecursoSolicitado;

class Autorizacion
{
    private Rol $_rol;
    private string $_recursoSolicitado;

    public function __construct(
        VerificarPermisosInterface $verificarPermisosInterface,
        Rol $rol,
        RecursoSolicitado $recursoSolicitado
    ) {
        $this->_rol = $rol;
        
        $this->_recursoSolicitado = $recursoSolicitado->recursoSolicitado();

        $verificarPermisosInterface->verificar($this->_rol->rol(), $recursoSolicitado->recursoSolicitado());
    }

    public function rol(): string
    {
        return $this->_rol->rol();
    }

    public function recursoSolicitado(): string
    {
        return $this->_recursoSolicitado;
    }
}
