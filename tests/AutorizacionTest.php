<?php declare(strict_types=1);
namespace tests;

use PHPUnit\Framework\TestCase;
use src\Autorizacion;
use src\CrearAutorizacionPorRecurso;
use src\CrearAutorizacionPorRol;
use src\DatosDeConfiguracion;
use src\excepciones\ElRecursoNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\ElRolNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\ElRolNoPuedeEstarVacioException;
use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;
use src\excepciones\NoTieneAutorizacionException;
use src\excepciones\RecursoSolicitadoVacioException;
use src\RecursoSolicitado;
use src\Rol;
use src\VerificarPorRecurso;
use src\VerificarPorRol;

class AutorizacionTest extends TestCase
{
    public function setUp(): void
    {
        $this->aut = new Autorizacion(
            new VerificarPorRol(
                new DatosDeConfiguracion(['admin' => ['leer']])
            ),
            new Rol('admin'),
            new RecursoSolicitado('leer')
        );

        $this->autRecurso = new Autorizacion(
            new VerificarPorRecurso(
                new DatosDeConfiguracion(['leer' => ['admin']])
            ),
            new Rol('admin'),
            new RecursoSolicitado('leer')
        );
    }

    //Autorizacion

    public function testAutorizacionDevuelveRolCorrecto()
    {
        $this->assertSame('admin', $this->aut->rol());
    }

    public function testAutorizacionDevuelveRecursoCorrecto()
    {
        $this->assertSame('leer', $this->aut->recursoSolicitado());
    }

    //DatosDeConfiguracion

    public function testDatosDeConfiguracionNoPuedeEstarVacio()
    {
        $this->expectException(LosDatosParaVerificarAutorizacionEstanVaciosException::class);
        $d = new DatosDeConfiguracion([]);
    }

    public function testDatosDeConfiguracionDevuelveArraySiEsCorrecto()
    {
        $d = new DatosDeConfiguracion(['admin' => ['leer']]);
        $this->assertIsArray($d->datos());
    }

    //RecursoSolicitado

    public function testRecursoSolicitadoDeVuelveExcepcionSiEstaVacio()
    {
        $this->expectException(RecursoSolicitadoVacioException::class);
        $r = new RecursoSolicitado('');
    }

    public function testRecursoSolicitadoDeVuelveStringCorrecto()
    {
        $r = new RecursoSolicitado('leer');
        $this->assertSame('leer', $r->recursoSolicitado());
    }

    //Rol

    public function testElRolNoPuedeEstarVacio()
    {
        $this->expectException(ElRolNoPuedeEstarVacioException::class);
        $r = new Rol('');
    }

    public function testRolDevuelveStringCorrecto()
    {
        $r = new Rol('admin');
        $this->assertSame('admin', $r->rol());
    }

    //VerificarPorRecurso

    public function testVerificarPorRecursoDevuelveExcepcionSiNoHayAutorizacion()
    {
        $this->expectException(NoTieneAutorizacionException::class);
        $v = new VerificarPorRecurso(
            new DatosDeConfiguracion(['leer' => ['admin']])
        );

        $v->verificar('invitado', 'leer');
    }

    public function testVerificarPorRecursoDevuelveExcepcionSiNoExisteElRecurso()
    {
        $this->expectException(ElRecursoNoExisteEnLosDatosDeVerificacionException::class);
        $v = new VerificarPorRecurso(
            new DatosDeConfiguracion(['leer' => ['admin']])
        );

        $v->verificar('admin', 'esribir');
    }

    //VerificaPorRol

    public function testVerificarPorRolDevuelveExcepcionSiNoHayAutorizacion()
    {
        $this->expectException(NoTieneAutorizacionException::class);
        $v = new VerificarPorRol(
            new DatosDeConfiguracion(['admin' => ['leer']])
        );

        $v->verificar('admin', 'escribir');
    }

    public function testVerificarPorRolDevuelveExcepcionSiElRolNoExisteEnLaConfiguracion()
    {
        $this->expectException(ElRolNoExisteEnLosDatosDeVerificacionException::class);
        $v = new VerificarPorRol(
            new DatosDeConfiguracion(['admin' => ['leer']])
        );

        $v->verificar('visitante', 'escribir');
    }

    //CrearAutorizacionPorRecurso

    public function testCrearAutorizacionPorRecursoDevuelveObjetoCorrecto()
    {
        $aut = new CrearAutorizacionPorRecurso();
        $this->assertInstanceOf(Autorizacion::class, $aut->crear([
            'rol' => 'admin',
            'datosVerificar' => [
                'leer' => [
                    'admin'
                ]
            ],
            'recursoSolicitado' => 'leer'
        ]));
    }

    //CrearAutorizacionPorRol

    public function testCrearAutorizacionPorRolDevuelveObjetoCorrecto()
    {
        $aut = new CrearAutorizacionPorRol();
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
