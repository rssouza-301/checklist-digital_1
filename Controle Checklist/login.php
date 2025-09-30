<?php
require_once 'db_connection.php';

if (isset($_SESSION['usuario_id'])) {
    // Já logado, redireciona para index
    header('Location: index.php');
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($login === '' || $senha === '') {
        $erro = "Por favor, preencha login e senha.";
    } else {
        // Busca usuário no banco
        $stmt = $conn->prepare("SELECT id, senha_hash FROM usuarios WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            // Verifica senha
            if (password_verify($senha, $usuario['senha_hash'])) {
                // Login OK
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_login'] = $login;
                header('Location: index.php');
                exit();
            } else {
                $erro = "Login ou senha incorretos.";
            }
        } else {
            $erro = "Login ou senha incorretos.";
        }
        $stmt->close();
    }
}

$page_title = "Login";
include 'template/header.php';
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm" style="width: 24rem;">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0"><i class="bi bi-box-arrow-in-right"></i> Acesso ao Sistema</h4>
        </div>
        <div class="card-body">
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php" novalidate>
                <div class="mb-3">
                    <label for="login" class="form-label">Login:</label>
                    <input type="text" class="form-control" id="login" name="login" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Entrar</button>
            </form>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>