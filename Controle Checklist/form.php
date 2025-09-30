<?php
require_once 'auth.php';
require_once 'db_connection.php';

$registro = null;
$is_editing = false;
$tipo = 'abertura'; // Padrão

// Lógica para edição (UPDATE)
if (isset($_GET['id'])) {
    $is_editing = true;
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM registros_checklist WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $registro = $result->fetch_assoc();
        $tipo = $registro['tipo'];
    } else {
        die("Registro não encontrado.");
    }
    $stmt->close();
} 
// Lógica para criação (CREATE)
elseif (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'] === 'fechamento' ? 'fechamento' : 'abertura';
}

$page_title = $is_editing ? "Editar Registro" : "Novo Checklist de " . ucfirst($tipo);
include 'template/header.php';
?>

<div class="card shadow-sm">
    <div class="card-header <?php echo $tipo === 'abertura' ? 'bg-success' : 'bg-danger'; ?> text-white">
        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> <?php echo $page_title; ?></h4>
    </div>
    <div class="card-body">
        <form action="salvar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $is_editing ? $registro['id'] : ''; ?>">
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">

            <h5><i class="bi bi-person-check-fill"></i> Identificação</h5>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="lider" class="form-label">Nome do Líder:</label>
                    <input type="text" class="form-control" id="lider" name="nome_lider" value="<?php echo htmlspecialchars($registro['nome_lider'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fiscal" class="form-label">Nome do Fiscal:</label>
                    <input type="text" class="form-control" id="fiscal" name="nome_fiscal" value="<?php echo htmlspecialchars($registro['nome_fiscal'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" class="form-control" id="data" name="data_checklist" value="<?php echo $registro['data_checklist'] ?? date('Y-m-d'); ?>" required>
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="coordenadas" class="form-label">Localização (GPS):</label>
                    <input type="text" class="form-control" id="coordenadas" name="coordenadas" value="<?php echo htmlspecialchars($registro['coordenadas'] ?? ''); ?>" placeholder="Coordenadas GPS">
                </div>
            </div>

            <h5><i class="bi bi-ui-checks"></i> Itens de Verificação</h5>
            <div class="bg-light p-3 rounded">
                <?php 
                $itens = [
                    'luzes_internas' => 'Luzes internas conferidas.',
                    'luzes_externas' => 'Luzes externas conferidas.',
                    'equipamentos_ok' => 'Equipamentos essenciais checados.',
                    'sistemas_ok' => 'Sistemas e computadores iniciados/encerrados.',
                    'risco_incendio_ok' => 'Verificação de riscos de incêndio.',
                    'passagem_servico_ok' => 'Passagem de serviço da vigilância.'
                ];
                foreach ($itens as $name => $label):
                    $checked = ($is_editing && $registro[$name] == 1) ? 'checked' : '';
                ?>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" <?php echo $checked; ?>>
                    <label class="form-check-label" for="<?php echo $name; ?>"><?php echo $label; ?></label>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label for="lacres" class="form-label">Nº dos Lacres (Retirados/Colocados):</label>
                    <textarea class="form-control" id="lacres" name="numero_lacres" rows="3"><?php echo htmlspecialchars($registro['numero_lacres'] ?? ''); ?></textarea>
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="observacoes" class="form-label">Observações Gerais:</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3"><?php echo htmlspecialchars($registro['observacoes'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                 <a href="listar_registros.php" class="btn btn-secondary">Cancelar</a>
                 <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Salvar Registro</button>
            </div>
        </form>
    </div>
</div>

<?php include 'template/footer.php'; ?>
