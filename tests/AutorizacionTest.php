<?php declare(strict_types=1);
namespace tests;

use PHPUnit\Framework\TestCase;
use src\Autorizacion;
use src\CrearAutorizacion;
use src\excepciones\ElRolNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;
use src\excepciones\NoTieneAutorizacionException;
use src\excepciones\RecursoSolicitadoVacioException;
use src\Rol;

class AutorizacionTest extends TestCase
{
    public function testAutorizacionDevuelveExcepcionSiNoHayAutorizacion()
    {
        $this->expectException(ElRolNoExisteEnLosDatosDeVerificacionException::class);
        
        $aut = new Autorizacion(
            new Rol('hola'),
            ['admin' => []],
            'inicio'
        );
    }

    public function testAutorizacionDevuelveExepcionSiNoSeTienePermiso()
    {
        $this->expectException(NoTieneAutorizacionException::class);

        $aut = new Autorizacion(
            new Rol('hola'),
            ['hola' => ['salir']],
            'inicio'
        );
    }

    public function testLosDatosParaVerificarAutorizacionEstanVaciosException()
    {
        $this->expectException(LosDatosParaVerificarAutorizacionEstanVaciosException::class);
        $aut = new Autorizacion(
            new Rol('hola'),
            [],
            'inicio'
        );
    }

    public function testAutorizacionDEvuelveRolCorrecto()
    {
        $aut = new Autorizacion(
            new Rol('hola'),
            ['hola' => ['inicio']],
            'inicio'
        );

        $this->assertSame('hola', $aut->rol());
    }

    public function testAutorizacionDevuelveExcepcionSiElRecursoSolicitadoEstaVacio()
    {
        $this->expectException(RecursoSolicitadoVacioException::class);
        $aut = new Autorizacion(
            new Rol('hola'),
            ['hola' => ['inicio']],
            ''
        );
    }

    public function testCrearAutorizacionDevuelveAutorizacion()
    {
        $aut = new CrearAutorizacion();
        $this->assertInstanceOf(Autorizacion::class, $aut->crear([
            'rol' => 'admin',
            'datosVerificar' => [
                'admin' => [
                    'leer'
                ]
            ],
            'recursoSolicitado' => 'leer'
        ]));
    }
}
