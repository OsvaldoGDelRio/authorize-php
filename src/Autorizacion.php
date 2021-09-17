<?php
namespace src;

use src\excepciones\ElRolNoExisteEnLosDatosDeVerificacionException;

use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;

use src\excepciones\RecursoSolicitadoVacioException;

use src\excepciones\NoTieneAutorizacionException;

class Autorizacion
{
    private array $_datos;
    private Rol $_rol;
    private string $_recursoSolicitado;

    public function __construct(Rol $rol, array $datos, string $recursoSolicitado)
    {
        $this->_rol = $rol;
        $this->_datos = $this->setDatos($datos);
        $this->_recursoSolicitado = $this->setRecursoSolicitado($recursoSolicitado);
        
        $this->verificar();
    }

    public function rol(): string
    {
        return $this->_rol->rol();
    }

    private function verificar(): void
    {
        $this->existeElRol();
        $this->tienePermisos();
    }

    private function tienePermisos(): void
    {
        if (!in_array($this->_recursoSolicitado, $this->_datos[$this->_rol->rol()])) {
            throw new NoTieneAutorizacionException("Ups no se tiene autorizacion para realizar esto");
        }
    }

    private function existeElRol(): void
    {
        if (!array_key_exists($this->_rol->rol(), $this->_datos)) {
            throw new ElRolNoExisteEnLosDatosDeVerificacionException("El rol no existe en los datos de verificación");
        }
    }

    private function setDatos(array $array): array
    {
        if (count($array) == 0) {
            throw new LosDatosParaVerificarAutorizacionEstanVaciosException("No existen datos para verificar la autorización");
        }

        return $array;
    }

    private function setRecursoSolicitado(string $string): string
    {
        if (empty($string)) {
            throw new RecursoSolicitadoVacioException("El recurso que se solicita no puede estar vacío");
        }

        return $string;
    }
}
