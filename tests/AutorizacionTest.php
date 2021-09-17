<?php declare(strict_types=1);
namespace tests;

use PHPUnit\Framework\TestCase;
use src\Autorizacion;
use src\excepciones\ElRecursoNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\ElRolNoExisteEnLosDatosDeVerificacionException;
use src\excepciones\ElRolNoPuedeEstarVacioException;
use src\excepciones\LosDatosParaVerificarAutorizacionEstanVaciosException;
use src\excepciones\NoTieneAutorizacionException;
use src\excepciones\RecursoSolicitadoVacioException;
use src\Rol;
use src\VerificarPorRecurso;
use src\VerificarPorRol;

class AutorizacionTest extends TestCase
{

    public function setUp(): void
    {
        $this->aut = new Autorizacion(
            new VerificarPorRol(['admin' => ['leer']]),
            new Rol('admin'),
            'leer'
        );
    }

    //Autorizacion

    public function testAutorizacionelRecusonoPuedeEstarVacio()
    {
        $this->expectException(RecursoSolicitadoVacioException::class);
        $aut = new Autorizacion(
            new VerificarPorRol(['admin' => 'leer']),
            new Rol('admin'),
            ''
        );
    }

    public function testAutorizacionDevuelveRolCorrecto()
    {
        $this->assertSame('admin', $this->aut->rol());
    }

    public function testAutorizacionDevuelveRecursoCorrecto()
    {
        $this->assertSame('leer', $this->aut->recursoSolicitado());
    }

    //Rol

    public function testRolNoPuedeEstarVacio()
    {
        $this->expectException(ElRolNoPuedeEstarVacioException::class);
        $rol = new Rol('');
    }

    public function testRolDevuelveRolCorrecto()
    {
        $rol = new Rol('admin');
        $this->assertSame('admin', $rol->rol());
    }

    //VerificarPorRecurso

    public function testVerificarPorRecursoDatosNoPuedeEstarVacio()
    {
        $this->expectException(LosDatosParaVerificarAutorizacionEstanVaciosException::class);
        $ver = new VerificarPorRecurso([]);
    }

    public function testNoTieneAutorizacionPorRecurso()
    {
        $this->expectException(NoTieneAutorizacionException::class);
        $ver = new VerificarPorRecurso(['leer' => ['admin']]);
        $ver->verificar('visitante', 'leer');
    }

    public function testElRecursoNoEstaEspecificadoEnLosDatos()
    {
        $this->expectException(ElRecursoNoExisteEnLosDatosDeVerificacionException::class);
        $ver = new VerificarPorRecurso(['leer' => ['admin']]);
        $ver->verificar('visitante', 'escribir');
    }

    

    //VerificarPorRol

    public function testVerificarPorRolDatosNoPuedeEstarVacio()
    {
        $this->expectException(LosDatosParaVerificarAutorizacionEstanVaciosException::class);
        $ver = new VerificarPorRol([]);
    }

    public function testNoTieneAutorizacionPorRol()
    {
        $this->expectException(NoTieneAutorizacionException::class);
        $ver = new VerificarPorRol(['admin' => ['leer']]);
        $ver->verificar('admin', 'escribir');
    }

    public function testElRolNoEstaEspecificadoEnLosDatos()
    {
        $this->expectException(ElRolNoExisteEnLosDatosDeVerificacionException::class);
        $ver = new VerificarPorRol(['visitante' => ['leer']]);
        $ver->verificar('admin', 'escribir');
    }

    
}
