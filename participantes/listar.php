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

$stmt = $conn->prepare($sql);
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
    <tbody>
        <?php if (count($participantes) > 0): ?>
            <?php foreach ($participantes as $p): ?>
                <?php
                if ($p['confirmado'] && $p['pago']) {
                    $situacao = "INSCRIÇÃO REGULARIZADA";
                    $classe_situacao = "regularizada";
                } elseif ($p['confirmado'] && !$p['pago']) {
                    $situacao = "PAGAMENTO PENDENTE";
                    $classe_situacao = "pendente";
                } else {
                    $situacao = "AGUARDANDO CONFIRMAÇÃO";
                    $classe_situacao = "aguardando";
                }
                ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['turma']) ?></td>
                    <td><?= htmlspecialchars($p['tipo_churrasco']) ?></td>
                    <td>
                        <?= $p['confirmado'] ? 'Confirmado' : 'Não confirmado' ?><br>
                        <a href="alterar_status.php?id=<?= $p['id'] ?>&campo=confirmado&valor=<?= $p['confirmado'] ? 0 : 1 ?>">
                            [<?= $p['confirmado'] ? 'Cancelar confirmação' : 'Confirmar presença' ?>]
                        </a>
                    </td>
                    <td>
                        <?= $p['pago'] ? 'Pago' : 'Pendente' ?><br>
                        <a href="alterar_status.php?id=<?= $p['id'] ?>&campo=pago&valor=<?= $p['pago'] ? 0 : 1 ?>">
                            [<?= $p['pago'] ? 'Desmarcar pagamento' : 'Confirmar pagamento' ?>]
                        </a>
                    </td>
                    <td><strong><?= $situacao ?></strong></td>
                    <td>
                        <a href="editar.php?id=<?= $p['id'] ?>">Editar</a> | 
                        <a href="excluir.php?id=<?= $p['id'] ?>" onclick="return confirmarExclusao(event)">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhum participante encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php include_once '../includes/rodape.php'; ?>