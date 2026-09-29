<?php
include "../includes/verificar_login.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/validar_form.js" defer></script>
</head>

<body>
    <form id="form-cadastro-participante" action="salvar.php" method="POST" novalidate>
        <label>
            <span>Nome</span>
            <input type="text" name="nome" id="nome" required>
        </label>
        <label>
            <span>Turma</span>
            <input type="text" name="turma" id="turma" required>
        </label>
        <label>
            <span>Telefone</span>
            <input type="text" name="telefone" id="telefone">
        </label>
        <label>
            <span>Acompanhamento</span>
            <input type="text" name="acompanhamento" id="acompanhamento">
        </label>
        <label>
            <span>Tipo de churrasco</span>
            <select name="tipo" id="tipo" required>
                <option value="tradicional">tradicional</option>
                <option value="vegano">vegano</option>
            </select>
        </label>
        <label>
            <span>Presença confirmada</span>
            <input type="checkbox" name="presenca">
        </label>
        <label>
            <span>Pagamento realizado</span>
            <input type="checkbox" name="pagamento">
        </label>
        <input type="submit" value="enviar">
    </form>
</body>

</html>