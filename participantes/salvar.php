<?php
include "../includes/verificar_login.php";
include "../config/conexao.php";

if(!isset($_POST['nome']) || !isset($_POST['turma']) || !isset($_POST['telefone']) || !isset($_POST['tipo']) || !isset($_POST['acompanhamento'])){
    echo "<script>alert('Preencha todos os campos!');
    window.location.href = 'cadastrar.php';</script>";
    exit;
}
$nome = $_POST['nome'];
$turma = $_POST['turma'];
$telefone = $_POST['telefone'];
$acompanhamento = $_POST['acompanhamento'];
$tipo = $_POST['tipo'];
$presenca = isset($_POST['presenca']) ? 1 : 0;
$pagamento = isset($_POST['pagamento']) ? 1 : 0;

$sql = "INSERT INTO participantes (nome, turma, telefone, acompanhamento, tipo, presenca, pagamento)
VALUES ('$nome', '$turma', '$telefone', '$acompanhamento', '$tipo', $presenca, $pagamento)";

$conn->query($sql);
?>