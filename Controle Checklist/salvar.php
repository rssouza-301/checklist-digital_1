<?php
require_once 'auth.php';
require_once 'db_connection.php';

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Coleta e limpa os dados do formulário
$id = (int)($_POST['id'] ?? 0);
$tipo = $_POST['tipo'] === 'fechamento' ? 'fechamento' : 'abertura';
$nome_lider = trim($_POST['nome_lider']);
$nome_fiscal = trim($_POST['nome_fiscal']);
$data_checklist = $_POST['data_checklist'];
$coordenadas = trim($_POST['coordenadas']);
$numero_lacres = trim($_POST['numero_lacres']);
$observacoes = trim($_POST['observacoes']);

// Trata os checkboxes
$luzes_internas = isset($_POST['luzes_internas']) ? 1 : 0;
$luzes_externas = isset($_POST['luzes_externas']) ? 1 : 0;
$equipamentos_ok = isset($_POST['equipamentos_ok']) ? 1 : 0;
$sistemas_ok = isset($_POST['sistemas_ok']) ? 1 : 0;
$risco_incendio_ok = isset($_POST['risco_incendio_ok']) ? 1 : 0;
$passagem_servico_ok = isset($_POST['passagem_servico_ok']) ? 1 : 0;

// Se o ID for maior que 0, é uma ATUALIZAÇÃO (UPDATE)
if ($id > 0) {
    $sql = "UPDATE registros_checklist SET tipo=?, nome_lider=?, nome_fiscal=?, data_checklist=?, coordenadas=?, luzes_internas=?, luzes_externas=?, equipamentos_ok=?, sistemas_ok=?, risco_incendio_ok=?, passagem_servico_ok=?, numero_lacres=?, observacoes=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssiiiiisssi",
        $tipo,
        $nome_lider,
        $nome_fiscal,
        $data_checklist,
        $coordenadas,
        $luzes_internas,
        $luzes_externas,
        $equipamentos_ok,
        $sistemas_ok,
        $risco_incendio_ok,
        $passagem_servico_ok,
        $numero_lacres,
        $observacoes,
        $id
    );
    $_SESSION['message'] = "Registro #{$id} atualizado com sucesso!";
} 
// Senão, é uma INSERÇÃO (CREATE)
else {
    $sql = "INSERT INTO registros_checklist (tipo, nome_lider, nome_fiscal, data_checklist, coordenadas, luzes_internas, luzes_externas, equipamentos_ok, sistemas_ok, risco_incendio_ok, passagem_servico_ok, numero_lacres, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssiiiiisss",
        $tipo,
        $nome_lider,
        $nome_fiscal,
        $data_checklist,
        $coordenadas,
        $luzes_internas,
        $luzes_externas,
        $equipamentos_ok,
        $sistemas_ok,
        $risco_incendio_ok,
        $passagem_servico_ok,
        $numero_lacres,
        $observacoes
    );
    $_SESSION['message'] = "Novo registro criado com sucesso!";
}

// Executa a query e redireciona
if ($stmt->execute()) {
    header('Location: listar_registros.php');
} else {
    // Em caso de erro, exibe uma mensagem
    die("Erro ao salvar o registro: " . $stmt->error);
}

$stmt->close();
$conn->close();
exit();
?>
