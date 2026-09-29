<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';

function voltarParaListagem(): void
{
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    voltarParaListagem();
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$campo = $_POST['campo'] ?? '';
$valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_INT);
$token = $_POST['csrf_token'] ?? null;

$token_valido = isset($_SESSION['csrf_token'])
    && is_string($token)
    && hash_equals($_SESSION['csrf_token'], $token);

if (
    !$id
    || !in_array($campo, ['confirmado', 'pago'], true)
    || !in_array($valor, [0, 1], true)
    || !$token_valido
) {
    voltarParaListagem();
}

$stmt = $conn->prepare("UPDATE participantes SET `$campo` = ? WHERE id = ?");
$stmt->bind_param('ii', $valor, $id);
$stmt->execute();

voltarParaListagem();
