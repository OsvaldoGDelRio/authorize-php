<?php
namespace src\interfaces;

interface VerificarPermisosInterface
{
    public function verificar(string $rol, string $recursoSolicitado): void;
}
