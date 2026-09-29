<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
include_once '../includes/cabecalho.php';

$pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';
$filtro_pago = isset($_GET['pago']) ? $_GET['pago'] : 'todos';
$filtro_confirmado = isset($_GET['confirmado']) ? $_GET['confirmado'] : 'todos';

$sql = "SELECT * FROM participantes WHERE 1=1";
$params = [];

if (!empty($pesquisa)) {
    $pesquisa_escapada = addcslashes($pesquisa, '%_');
    $sql .= " AND nome LIKE :pesquisa";
    $params[':pesquisa'] = "%{$pesquisa_escapada}%";
}

if ($filtro_pago === 'sim') {
    $sql .= " AND pago = 1";
} elseif ($filtro_pago === 'nao') {
    $sql .= " AND pago = 0";
}

if ($filtro_confirmado === 'sim') {
    $sql .= " AND confirmado = 1";
} elseif ($filtro_confirmado === 'nao') {
    $sql .= " AND confirmado = 0";
}

$sql .= " ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$participantes = $stmt->fetchAll();
?>

<h2>Listagem de Participantes</h2>

<form method="GET" action="listar.php" class="form-filtro">
    <div class="campo-grupo">
        <input type="text" name="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Pesquisar por nome...">
        <button type="submit" class="btn btn-principal">Pesquisar</button>
    </div>
    
    <div class="campo-grupo">
        <label>Pagamento:</label>
        <select name="pago" onchange="this.form.submit()">
            <option value="todos" <?= $filtro_pago === 'todos' ? 'selected' : '' ?>>Todos</option>
            <option value="sim" <?= $filtro_pago === 'sim' ? 'selected' : '' ?>>Pagos</option>
            <option value="nao" <?= $filtro_pago === 'nao' ? 'selected' : '' ?>>Pendentes</option>
        </select>

        <label>Presença:</label>
        <select name="confirmado" onchange="this.form.submit()">
            <option value="todos" <?= $filtro_confirmado === 'todos' ? 'selected' : '' ?>>Todos</option>
            <option value="sim" <?= $filtro_confirmado === 'sim' ? 'selected' : '' ?>>Confirmados</option>
            <option value="nao" <?= $filtro_confirmado === 'nao' ? 'selected' : '' ?>>Não confirmados</option>
        </select>
        
        <a href="listar.php" class="btn btn-secundario">Limpar Filtros</a>
    </div>
</form>

<table class="tabela-dados">
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
                    $classe_situacao = "badge badge-sucesso";
                } elseif ($p['confirmado'] && !$p['pago']) {
                    $situacao = "PAGAMENTO PENDENTE";
                    $classe_situacao = "badge badge-alerta";
                } else {
                    $situacao = "AGUARDANDO CONFIRMAÇÃO";
                    $classe_situacao = "badge badge-neutro";
                }
                ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['turma']) ?></td>
                    <td><?= htmlspecialchars($p['tipo_churrasco']) ?></td>
                    <td>
                        <?= $p['confirmado'] ? 'Confirmado' : 'Não confirmado' ?><br>
                        <a href="alterar_status.php?id=<?= $p['id'] ?>&campo=confirmado&valor=<?= $p['confirmado'] ? 0 : 1 ?>" class="link-acao">
                            <?= $p['confirmado'] ? '[Cancelar confirmação]' : '[Confirmar presença]' ?>
                        </a>
                    </td>
                    <td>
                        <?= $p['pago'] ? 'Pago' : 'Pendente' ?><br>
                        <a href="alterar_status.php?id=<?= $p['id'] ?>&campo=pago&valor=<?= $p['pago'] ? 0 : 1 ?>" class="link-acao">
                            <?= $p['pago'] ? '[Desmarcar pagamento]' : '[Confirmar pagamento]' ?>
                        </a>
                    </td>
                    <td><span class="<?= $classe_situacao ?>"><?= $situacao ?></span></td>

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