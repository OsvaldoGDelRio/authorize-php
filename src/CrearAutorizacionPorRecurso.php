<?php
namespace src;

use src\Autorizacion;
use src\Rol;
use src\VerificarPorRecurso;
use src\FactoryClassInterface;

class CrearAutorizacionPorRecurso implements FactoryClassInterface
{
    public function crear(array $array): Autorizacion
    {
        return new Autorizacion(
            new VerificarPorRecurso($array['datosVerificar']),
            new Rol($array['rol']),
            $array['recursoSolicitado']
        );
    }
}
