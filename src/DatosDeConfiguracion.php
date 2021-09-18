<?php
namespace src;

use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;

class DatosDeConfiguracion
{
    private array $_datos;

    public function __construct(array $datos)
    {
        $this->_datos = $this->setDatos($datos);
    }

    public function datos(): array
    {
        return $this->_datos;
    }

    private function setDatos(array $array): array
    {
        if (count($array) == 0) {
            throw new LosDatosParaVerificarAutorizacionEstanVaciosException("Los datos para verificar si existe autorización están vacíos", 1);
        }

        return $array;
    }
}
