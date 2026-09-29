<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
$titulo_pagina = 'Participantes';
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

<section>
<div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-[#bd4a2f]">Gestão de inscrições</p>
        <h1 class="font-display text-3xl text-[#174b3a] sm:text-4xl">Participantes</h1>
        <p class="mt-2 text-sm text-[#68766d]">Consulte, filtre e atualize as inscrições.</p>
    </div>
    <a href="cadastrar.php" class="inline-flex items-center justify-center rounded-lg bg-[#bd4a2f] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#a83d26]">+ Nova inscrição</a>
</div>

<form method="GET" action="listar.php" class="mb-6 grid gap-4 rounded-xl border border-[#d9dfd5] bg-white p-4 sm:grid-cols-2 lg:grid-cols-[minmax(220px,1fr)_180px_180px_auto] lg:items-end" id="form-filtro-participantes">
    <label>
        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.1em] text-[#68766d]">Pesquisar nome</span>
        <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition placeholder:text-[#9aa49d] focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="search" name="pesquisa" value="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>" placeholder="Digite um nome">
    </label>
    <label>
        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.1em] text-[#68766d]">Pagamento</span>
        <select class="w-full rounded-lg border border-[#cbd5cb] bg-white px-3 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" name="pago">
            <option value="todos" <?= $filtro_pago === 'todos' ? 'selected' : '' ?>>Todos</option>
            <option value="sim" <?= $filtro_pago === 'sim' ? 'selected' : '' ?>>Pagos</option>
            <option value="nao" <?= $filtro_pago === 'nao' ? 'selected' : '' ?>>Pendentes</option>
        </select>
    </label>
    <label>
        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.1em] text-[#68766d]">Presença</span>
        <select class="w-full rounded-lg border border-[#cbd5cb] bg-white px-3 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" name="confirmado">
            <option value="todos" <?= $filtro_confirmado === 'todos' ? 'selected' : '' ?>>Todos</option>
            <option value="sim" <?= $filtro_confirmado === 'sim' ? 'selected' : '' ?>>Confirmados</option>
            <option value="nao" <?= $filtro_confirmado === 'nao' ? 'selected' : '' ?>>Não confirmados</option>
        </select>
    </label>
    <div class="flex gap-2 sm:col-span-2 lg:col-span-1">
        <button type="submit" class="flex-1 rounded-lg bg-[#174b3a] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#103b2d]">Filtrar</button>
        <a href="listar.php" class="flex-1 rounded-lg border border-[#cbd5cb] px-4 py-3 text-center text-sm font-bold text-[#39584a] transition hover:bg-[#f6f8f4]">Limpar</a>
    </div>
</form>

<div class="overflow-hidden rounded-xl border border-[#d9dfd5] bg-white">
<div class="overflow-x-auto">
<table class="w-full min-w-[900px] border-collapse text-left text-sm">
    <thead>
        <tr class="border-b border-[#d9dfd5] bg-[#f3f6f1] text-xs uppercase tracking-[0.08em] text-[#68766d]">
            <th class="px-4 py-4 font-bold">Nome</th>
            <th class="px-4 py-4 font-bold">Turma</th>
            <th class="px-4 py-4 font-bold">Tipo</th>
            <th class="px-4 py-4 font-bold">Presença</th>
            <th class="px-4 py-4 font-bold">Pagamento</th>
            <th class="px-4 py-4 font-bold">Inscrição</th>
            <th class="px-4 py-4 font-bold">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($participantes) > 0): ?>
            <?php foreach ($participantes as $p): ?>
                <?php
                if ($p['confirmado'] && $p['pago']) {
                    $situacao = "INSCRIÇÃO REGULARIZADA";
                    $classe_situacao = "inline-flex rounded-full bg-[#e7f2e8] px-3 py-1 text-xs font-bold text-[#28613c]";
                } elseif ($p['confirmado'] && !$p['pago']) {
                    $situacao = "PAGAMENTO PENDENTE";
                    $classe_situacao = "inline-flex rounded-full bg-[#fff0d9] px-3 py-1 text-xs font-bold text-[#8a5314]";
                } else {
                    $situacao = "AGUARDANDO CONFIRMAÇÃO";
                    $classe_situacao = "inline-flex rounded-full bg-[#edf0ed] px-3 py-1 text-xs font-bold text-[#58665d]";
                }
                ?>
                <tr class="border-b border-[#edf0eb] align-top last:border-0 hover:bg-[#fbfcfa]">
                    <td class="px-4 py-4 font-bold text-[#294a3b]"><?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-4 text-[#58665d]"><?= htmlspecialchars($p['turma'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-4 text-[#58665d]"><?= htmlspecialchars($p['tipo_churrasco'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="px-4 py-4">
                        <span class="font-semibold text-[#294a3b]"><?= $p['confirmado'] ? 'Confirmado' : 'Não confirmado' ?></span>
                        <form class="mt-1" method="POST" action="confirmar.php">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <input type="hidden" name="campo" value="confirmado">
                            <input type="hidden" name="valor" value="<?= $p['confirmado'] ? 0 : 1 ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="text-xs font-bold text-[#bd4a2f] underline decoration-[#bd4a2f]/40 underline-offset-4 hover:text-[#8f3522]">
                            <?= $p['confirmado'] ? '[Cancelar confirmação]' : '[Confirmar presença]' ?>
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-4">
                        <span class="font-semibold text-[#294a3b]"><?= $p['pago'] ? 'Pago' : 'Pendente' ?></span>
                        <form class="mt-1" method="POST" action="confirmar.php">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <input type="hidden" name="campo" value="pago">
                            <input type="hidden" name="valor" value="<?= $p['pago'] ? 0 : 1 ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="text-xs font-bold text-[#bd4a2f] underline decoration-[#bd4a2f]/40 underline-offset-4 hover:text-[#8f3522]">
                            <?= $p['pago'] ? '[Desmarcar pagamento]' : '[Confirmar pagamento]' ?>
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-4"><span class="<?= $classe_situacao ?>"><?= $situacao ?></span></td>

                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <a class="font-bold text-[#174b3a] hover:underline" href="editar.php?id=<?= (int)$p['id'] ?>">Editar</a>
                            <a class="font-bold text-[#bd4a2f] hover:underline" href="excluir.php?id=<?= (int)$p['id'] ?>" onclick="return confirmarExclusao(event)">Excluir</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="px-4 py-12 text-center text-sm text-[#78847b]" colspan="7">Nenhum participante encontrado com esses filtros.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>
</section>
<?php include_once '../includes/rodape.php'; ?>