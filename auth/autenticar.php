<?php
include "../config/conexao.php";
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$consulta = $conn->prepare("SELECT id, email, senha FROM usuarios WHERE email = ?");
$consulta->bind_param("s", $email);
$consulta->execute();
$resultado = $consulta->get_result()->fetch_assoc();

$senha_valida = $resultado && password_verify($senha, $resultado['senha']);

if ($senha_valida) {
    session_start();
    $_SESSION['email'] = $resultado['email'];
    header("Location: ../index.php");
    exit();
}

header("Location: login.php?erro=1");
exit();