<?php
// auth.php - incluir no topo das páginas que precisam de login

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    // Usuário não autenticado, redireciona para login
    header('Location: login.php');
    exit();
}
?>
