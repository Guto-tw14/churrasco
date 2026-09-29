<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
$titulo_pagina = 'Editar participante';
include_once '../includes/cabecalho.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM participantes WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

if (!$p) {
    echo '<div class="rounded-xl border border-[#e8c7bd] bg-white p-6"><h1 class="font-display text-2xl text-[#174b3a]">Participante não encontrado</h1><a class="mt-4 inline-flex font-bold text-[#bd4a2f] underline underline-offset-4" href="listar.php">Voltar aos participantes</a></div>';
    include_once '../includes/rodape.php';
    exit;
}
?>

<section class="mx-auto max-w-3xl">
    <div class="mb-7">
        <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-[#bd4a2f]">Participantes</p>
        <h1 class="font-display text-3xl text-[#174b3a] sm:text-4xl">Editar participante</h1>
        <p class="mt-2 text-sm leading-6 text-[#68766d]">Atualize os dados de <?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?>.</p>
    </div>

<form action="atualizar.php" method="POST" class="rounded-xl border border-[#d9dfd5] bg-white p-5 shadow-sm sm:p-8">
    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">

    <div class="grid gap-5 sm:grid-cols-2">
        <label class="sm:col-span-2">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Nome</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="text" name="nome" id="nome" value="<?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?>" required>
        </label>

        <label>
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Turma</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="text" name="turma" id="turma" value="<?= htmlspecialchars($p['turma'], ENT_QUOTES, 'UTF-8') ?>" required>
        </label>

        <label>
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Telefone</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="tel" name="telefone" id="telefone" value="<?= htmlspecialchars($p['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label>

        <label>
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Tipo de churrasco</span>
            <select class="w-full rounded-lg border border-[#cbd5cb] bg-white px-4 py-3 text-sm outline-none transition focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" name="tipo_churrasco" id="tipo_churrasco" required>
                <option value="Tradicional" <?= $p['tipo_churrasco'] === 'Tradicional' ? 'selected' : '' ?>>Tradicional</option>
                <option value="Vegetariano" <?= $p['tipo_churrasco'] === 'Vegetariano' ? 'selected' : '' ?>>Vegetariano</option>
            </select>
        </label>

        <label class="sm:col-span-2">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Acompanhamento</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="text" name="acompanhamento" id="acompanhamento" value="<?= htmlspecialchars($p['acompanhamento'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </label>
    </div>

    <fieldset class="mt-7 grid gap-3 border-t border-[#e7ebe4] pt-6 sm:grid-cols-2">
        <legend class="sr-only">Situação da inscrição</legend>
        <label class="flex cursor-pointer items-center gap-3 rounded-lg bg-[#f6f8f4] px-4 py-3 text-sm font-semibold text-[#39584a]">
            <input type="hidden" name="confirmado" value="0">
            <input class="h-4 w-4 accent-[#174b3a]" type="checkbox" name="confirmado" id="confirmado" value="1" <?= $p['confirmado'] ? 'checked' : '' ?>>
            Presença confirmada
        </label>
        <label class="flex cursor-pointer items-center gap-3 rounded-lg bg-[#f6f8f4] px-4 py-3 text-sm font-semibold text-[#39584a]">
            <input type="hidden" name="pago" value="0">
            <input class="h-4 w-4 accent-[#174b3a]" type="checkbox" name="pago" id="pago" value="1" <?= $p['pago'] ? 'checked' : '' ?>>
            Pagamento realizado
        </label>
    </fieldset>

    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-[#e7ebe4] pt-6 sm:flex-row sm:justify-end">
        <a href="listar.php" class="inline-flex items-center justify-center rounded-lg border border-[#cbd5cb] px-5 py-3 text-sm font-bold text-[#39584a] transition hover:bg-[#f6f8f4]">Cancelar</a>
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#174b3a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#103b2d]">Salvar alterações</button>
    </div>
</form>
</section>

<?php include_once '../includes/rodape.php'; ?>