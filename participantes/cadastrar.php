<?php
include "../includes/verificar_login.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="salvar.php" method="POST">
        <label>
            <span>Nome</span>
            <input type="text" name="nome" required>
        </label>
        <label>
            <span>Turma</span>
            <input type="text" name="turma" required>
        </label>
        <label>
            <span>Telefone</span>
            <input type="text" name="telefone">
        </label>
        <label>
            <span>Acompanhamento</span>
            <input type="text" name="acompanhamento">
        </label>
        <label>
            <span>Tipo de churrasco</span>
            <select name="tipo" required>
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