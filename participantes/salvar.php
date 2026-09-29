<?php
include "../includes/verificar_login.php";
include "../config/conexao.php";

$nome = trim($_POST['nome'] ?? '');
$turma = trim($_POST['turma'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$acompanhamento = trim($_POST['acompanhamento'] ?? '');
$tipo = trim($_POST['tipo'] ?? '');

if ($nome === '' || $turma === '' || $tipo === '') {
    echo "<script>alert('Preencha nome, turma e tipo de churrasco.');
    window.location.href = 'cadastrar.php';</script>";
    exit;
}
$presenca = isset($_POST['presenca']) ? 1 : 0;
$pagamento = isset($_POST['pagamento']) ? 1 : 0;

$sql = "INSERT INTO participantes (nome, turma, telefone, acompanhamento, tipo_churrasco, confirmado, pago)
VALUES ('$nome', '$turma', '$telefone', '$acompanhamento', '$tipo', $presenca, $pagamento)";

$conn->query($sql);

echo "<script>alert('Participante cadastrado com sucesso!');
window.location.href = '../index.php';</script>";

?>