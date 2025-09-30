<?php
require_once 'auth.php'; // só acessível para usuários logados
require_once 'db_connection.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $senha_confirm = $_POST['senha_confirm'] ?? '';

    if ($login === '' || $senha === '' || $senha_confirm === '') {
        $erro = "Por favor, preencha todos os campos.";
    } elseif ($senha !== $senha_confirm) {
        $erro = "As senhas não coincidem.";
    } else {
        // Verifica se login já existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "Este login já está em uso.";
        } else {
            // Insere novo usuário com senha hash
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt_insert = $conn->prepare("INSERT INTO usuarios (login, senha_hash) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $login, $senha_hash);
            if ($stmt_insert->execute()) {
                $sucesso = "Usuário criado com sucesso!";
            } else {
                $erro = "Erro ao criar usuário: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }
        $stmt->close();
    }
}

$page_title = "Cadastro de Usuário";
include 'template/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-3">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="bi bi-ui-checks-grid"></i> Controle Operacional</a>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">
        <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['usuario_login']); ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">
        <i class="bi bi-box-arrow-right"></i> Sair
      </a>
    </div>
  </div>
</nav>

<div class="card mx-auto" style="max-width: 400px;">
    <div class="card-header bg-primary text-white text-center">
        <h4><i class="bi bi-person-plus-fill"></i> Cadastro de Novo Usuário</h4>
    </div>
    <div class="card-body">
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
        <?php elseif ($sucesso): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
        <?php endif; ?>

        <form method="POST" action="cadastro_usuario.php" novalidate>
            <div class="mb-3">
                <label for="login" class="form-label">Login:</label>
                <input type="text" class="form-control" id="login" name="login" required autofocus value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="senha_confirm" class="form-label">Confirme a Senha:</label>
                <input type="password" class="form-control" id="senha_confirm" name="senha_confirm" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Cadastrar</button>
            </div>
        </form>
    </div>
</div>

<?php include 'template/footer.php'; ?>
