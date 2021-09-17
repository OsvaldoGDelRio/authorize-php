<?php
namespace src;

use src\Autorizacion;
use src\Rol;
use src\FactoryClassInterface;

class CrearAutorizacion implements FactoryClassInterface
{
    public function crear(array $array): Autorizacion
    {
        return new Autorizacion(
            new Rol($array['rol']),
            $array['datosVerificar'],
            $array['recursoSolicitado']
        );
    }
}
