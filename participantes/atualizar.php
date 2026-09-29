<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nome = trim($_POST['nome']);
    $turma = trim($_POST['turma']);
    $telefone = trim($_POST['telefone']);
    $tipo_churrasco = $_POST['tipo_churrasco'];
    $acompanhamento = trim($_POST['acompanhamento']);
    $confirmado = (int)$_POST['confirmado'];
    $pago = (int)$_POST['pago'];

    if (!empty($nome) && !empty($turma) && !empty($tipo_churrasco) && $id > 0) {
        $sql = "UPDATE participantes SET 
                    nome = ?, 
                    turma = ?, 
                    telefone = ?, 
                    tipo_churrasco = ?, 
                    acompanhamento = ?, 
                    confirmado = ?, 
                    pago = ? 
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            'sssssiii',
            $nome,
            $turma,
            $telefone,
            $tipo_churrasco,
            $acompanhamento,
            $confirmado,
            $pago,
            $id
        );
        $stmt->execute();
    }
}

header("Location: listar.php");
exit;
?>