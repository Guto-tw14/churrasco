<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM participantes WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header("Location: listar.php");
exit;
?>