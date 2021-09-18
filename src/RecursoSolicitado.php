<?php
namespace src;

use src\excepciones\RecursoSolicitadoVacioException;

class RecursoSolicitado
{
    private string $_recurso;

    public function __construct(string $recurso)
    {
        $this->_recurso = $this->setRecurso($recurso);
    }

    public function recursoSolicitado(): string
    {
        return $this->_recurso;
    }

    private function setRecurso(string $recurso): string
    {
        if (empty($recurso)) {
            throw new RecursoSolicitadoVacioException("El recurso que se solicita no puede estar vacío");
        }

        return $recurso;
    }
}
