<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
include_once '../includes/cabecalho.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';
$filtro_pago = isset($_GET['pago']) ? $_GET['pago'] : 'todos';
$filtro_confirmado = isset($_GET['confirmado']) ? $_GET['confirmado'] : 'todos';

$sql = "SELECT * FROM participantes WHERE 1=1";

if (!empty($pesquisa)) {
    $pesquisa_escapada = addcslashes($pesquisa, '%_');
    $termo_pesquisa = "%{$pesquisa_escapada}%";
    $sql .= " AND nome LIKE ?";
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
$stmt = $conn->prepare($sql);
if (isset($termo_pesquisa)) {
    $stmt->bind_param('s', $termo_pesquisa);
}
$stmt->execute();
$participantes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<script src="../js/script.js" defer></script>

<h2>Listagem de Participantes</h2>

<form method="GET" action="listar.php" class="form-filtro" id="form-filtro-participantes">
    <div class="campo-grupo">
        <input type="text" name="pesquisa" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="Pesquisar por nome...">
        <button type="submit" class="btn btn-principal">Pesquisar</button>
    </div>
    
    <div class="campo-grupo">
        <label>Pagamento:</label>
        <select name="pago">
            <option value="todos" <?= $filtro_pago === 'todos' ? 'selected' : '' ?>>Todos</option>
            <option value="sim" <?= $filtro_pago === 'sim' ? 'selected' : '' ?>>Pagos</option>
            <option value="nao" <?= $filtro_pago === 'nao' ? 'selected' : '' ?>>Pendentes</option>
        </select>

        <label>Presença:</label>
        <select name="confirmado">
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
                        <form method="POST" action="confirmar.php">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <input type="hidden" name="campo" value="confirmado">
                            <input type="hidden" name="valor" value="<?= $p['confirmado'] ? 0 : 1 ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="link-acao">
                            <?= $p['confirmado'] ? '[Cancelar confirmação]' : '[Confirmar presença]' ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <?= $p['pago'] ? 'Pago' : 'Pendente' ?><br>
                        <form method="POST" action="confirmar.php">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <input type="hidden" name="campo" value="pago">
                            <input type="hidden" name="valor" value="<?= $p['pago'] ? 0 : 1 ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="link-acao">
                            <?= $p['pago'] ? '[Desmarcar pagamento]' : '[Confirmar pagamento]' ?>
                            </button>
                        </form>
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