<?php
namespace src;

use src\Autorizacion;
use src\Rol;
use src\VerificarPorRol;
use src\FactoryClassInterface;

class CrearAutorizacionPorRol implements FactoryClassInterface
{
    public function crear(array $array): Autorizacion
    {
        return new Autorizacion(
            new VerificarPorRol(
                new DatosDeConfiguracion($array['datosVerificar'])
            ),
            new Rol($array['rol']),
            new RecursoSolicitado($array['recursoSolicitado'])
        );
    }
}
