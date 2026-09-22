<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
require_once '../includes/cabecalho.php';

$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$filtro_pago = isset($_GET['filtro_pago']) ? $_GET['filtro_pago'] : '';
$filtro_confirmado = isset($_GET['filtro_confirmado']) ? $_GET['filtro_confirmado'] : '';

$sql = "SELECT * FROM participantes WHERE nome LIKE :pesquisa";
$params = [];
if (!empty($pesquisa)) {
    $sql .= " AND nome LIKE :pesquisa";
    $params[':pesquisa'] = '%' . $pesquisa . '%';
} 
if (($filtro_pago === 'sim')) {
    $sql .= " AND pago = :filtro_pago";
    $params[':filtro_pago'] = 1;
} elseif (($filtro_pago === 'nao')) {
    $sql .= " AND pago = :filtro_pago";
    $params[':filtro_pago'] = 0;
}
if (($filtro_confirmado === 'sim')) {
    $sql .= " AND confirmado = :filtro_confirmado";
    $params[':filtro_confirmado'] = 1;
} elseif (($filtro_confirmado === 'nao')) {
    $sql .= " AND confirmado = :filtro_confirmado";
    $params[':filtro_confirmado'] = 0;
}

$sql .= " ORDER BY nome ASC";

$stmt = $cone->prepare($sql);
$stmt->execute($params);
$participantes = $stmt->fetchAll();
?>

<h2>Lista de Participantes</h2>
<form method="GET" action="listar.php">
    <div>
        <label for="pesquisa">Pesquisar por nome:</label>
        <input type="text" name="pesquisa" id="pesquisa" value="<?php echo htmlspecialchars($pesquisa); ?>">
    </div>
        <form method="GET" action="listar.php">
            <div>
                <label for="pesquisa">Pesquisar participante:</label>
                <input type="text" name="pesquisa" id="pesquisa" value="<?php echo htmlspecialchars($pesquisa); ?>">
                <button type="submit">Pesquisar</button>
            </div>
            <label>Pagamento:</label>
            <select name="filtro_pago" onchange="this.form.submit()">
                    <option value="todos" <?php if ($filtro_pago === 'todos') echo 'selected'; ?>>Todos</option>
                    <option value="sim" <?php if ($filtro_pago === 'sim') echo 'selected'; ?>>Pago</option>
                    <option value="nao" <?php if ($filtro_pago === 'nao') echo 'selected'; ?>>Não Pago</option>
            </select>
            <label>Presença:</label>
            <select name="confirmado" onchange="this.form.submit()">
                <option value="todos" <?php if ($filtro_confirmado === 'todos') echo 'selected'; ?>>Todos</option>
                <option value="sim" <?php if ($filtro_confirmado === 'sim') echo 'selected'; ?>>Confirmado</option>
                <option value="nao" <?php if ($filtro_confirmado === 'nao') echo 'selected'; ?>>Não Confirmado</option>
            </select>
            
            <a href="listar.php">Limpar Filtros</a>
        </div>
</form>

<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Turma</th>
            <th>Tipo</th>
            <th>Presença</th>
            <th>Pagamento</th>
            <th>Situação da Inscrição</th>
            <th>Ações</th>
        </tr>
    </thead>
        <thead>
        <?php foreach ($participantes as $participante): ?>
            <tr>
                <td><?php echo htmlspecialchars($participante['nome']); ?></td>
                <td><?php echo htmlspecialchars($participante['email']); ?></td>
                <td><?php echo htmlspecialchars($participante['telefone']); ?></td>
                <td><?php echo $participante['pago'] ? 'Pago' : 'Não Pago'; ?></td>
                <td><?php echo $participante['confirmado'] ? 'Confirmado' : 'Não Confirmado'; ?></td>
            </tr>
        </thead>
        <tbody>
        <?php endforeach; ?>