<?php 
require_once 'auth.php'; // Verifica login
$page_title = "Menu Principal";
include 'template/header.php'; 
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-3">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="bi bi-ui-checks-grid"></i> Controle Operacional</a>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">
        <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['usuario_login']); ?>
      </span>
      <a href="cadastro_usuario.php" class="btn btn-outline-light btn-sm ms-3">
        <i class="bi bi-person-plus-fill"></i> Novo Usuário
      </a>
      <a href="logout.php" class="btn btn-outline-light btn-sm">
        <i class="bi bi-box-arrow-right"></i> Sair
      </a>
    </div>
  </div>
</nav>

<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card text-center shadow-lg" style="width: 24rem;">
        <div class="card-header">
            <h4 class="mb-0">Menu de Ações</h4>
        </div>
        <div class="card-body p-4">
            <h5 class="card-title">Gerenciador de Checklists</h5>
            <p class="card-text">Selecione uma das opções para criar um novo registro ou visualizar os existentes.</p>
            <div class="d-grid gap-3">
                <a href="form.php?tipo=abertura" class="btn btn-success btn-lg">
                    <i class="bi bi-box-arrow-right"></i> Novo Checklist de Abertura
                </a>
                <a href="form.php?tipo=fechamento" class="btn btn-danger btn-lg">
                    <i class="bi bi-box-arrow-in-left"></i> Novo Checklist de Fechamento
                </a>
                <a href="listar_registros.php" class="btn btn-info btn-lg text-white">
                    <i class="bi bi-card-list"></i> Ver Todos os Registros
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>
