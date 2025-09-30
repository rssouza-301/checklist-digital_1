<?php
// Ativar a exibição de erros para depuração (remover em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar a sessão para usar mensagens flash e controle de login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servidor = "localhost";
$usuario = "root";
$senha = "root";
$banco = "controle_checklist";

$conn = new mysqli($servidor, $usuario, $senha, $banco, 8889);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
