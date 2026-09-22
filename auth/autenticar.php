<?php
include "../config/conexao.php";
$sql = "SELECT * FROM usuarios WHERE email = '{$_POST['email']}' AND senha = '{$_POST['senha']}'";
$res = $conn->query($sql);
$resultado = $res->fetch_assoc();
if($resultado){
    session_start();
    $_SESSION['email'] = $resultado['email'];
    $_SESSION['senha'] = $resultado['senha'];
    header("Location: ../index.php");
}
else{
    echo "<script>
        alert('Email ou senha incorretos');
        window.location.href = '../auth/login.php';
    </script>";
}
?>