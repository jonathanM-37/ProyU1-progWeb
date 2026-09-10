<?php
session_start();

// Credenciales válidas (sin base de datos)
$usuarios = [
    'administrador' => ['contrasena' => 'asd',  'tipo' => 'administrador'],
    'cliente'       => ['contrasena' => '123',   'tipo' => 'cliente'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario    = trim($_POST['usuario']    ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    if (isset($usuarios[$usuario]) && $usuarios[$usuario]['contrasena'] === $contrasena) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo']    = $usuarios[$usuario]['tipo'];

        if ($usuarios[$usuario]['tipo'] === 'administrador') {
            header('Location: dashboard.php');
        } else {
            header('Location: catalogo.php');
        }
        exit;
    } else {
        header('Location: error.php');
        exit;
    }
}

// Si acceden directamente por GET sin POST, redirige al login
header('Location: index.php');
exit;
