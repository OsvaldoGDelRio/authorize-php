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
