<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM participantes WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: listar.php");
exit;
?>