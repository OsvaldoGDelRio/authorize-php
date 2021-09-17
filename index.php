<?php
declare(strict_types=1);

use src\Autorizacion;
use src\Rol;

require_once __DIR__ . '/vendor/autoload.php';

$permisosPorRol = [
    'admin' => [
        'escribir',
        'leer',
        'ver'
    ],
    'visitante' => [
        'leer',
        'ver'
    ]
];

$admin = new Rol('admin');
$visitante = new Rol('visitante');

$accion = 'borrar';

try {
    new Autorizacion($admin, $permisosPorRol, $accion);
} catch (\Throwable $th) {
    echo '<h1>El admin no tiene autorización para '.$accion.'</h1>';
}

try {
    new Autorizacion($visitante, $permisosPorRol, $accion);
} catch (\Throwable $th) {
    echo '<h1>El visitante no tiene autorización para '.$accion.'</h1>';
}