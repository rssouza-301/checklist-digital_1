<?php
require_once 'auth.php';
require_once 'db_connection.php';
$page_title = "Listagem de Registros";
include 'template/header.php';

// Busca todos os registros, ordenando pelos mais recentes
$sql = "SELECT id, tipo, data_checklist, nome_lider, nome_fiscal FROM registros_checklist ORDER BY id DESC";
$result = $conn->query($sql);
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

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-card-list"></i> Todos os Registros</h2>
    <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar ao Menu</a>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>