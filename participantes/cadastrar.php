<?php
require_once '../includes/verificar_login.php';
$titulo_pagina = 'Nova inscrição';
include_once '../includes/cabecalho.php';
?>
<script src="../js/validar_form.js" defer></script>

<section class="mx-auto max-w-4xl">
    <div class="mb-4">
        <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-[#bd4a2f]">Participantes</p>
        <h1 class="font-display text-2xl text-[#174b3a] sm:text-3xl">Nova inscrição</h1>
    </div>

    <form id="form-cadastro-participante" action="salvar.php" method="POST" novalidate class="grid gap-4 rounded-xl border border-[#d9dfd5] bg-white p-4 shadow-sm sm:grid-cols-2 sm:p-5">
        <label class="block sm:col-span-2">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Nome</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="text" name="nome" id="nome" autocomplete="name" placeholder="Nome completo" required>
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Turma</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="text" name="turma" id="turma" placeholder="Ex.: 301" required>
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Telefone</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="tel" name="telefone" id="telefone" autocomplete="tel" placeholder="(00) 00000-0000">
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Tipo de churrasco</span>
            <select class="w-full rounded-lg border border-[#cbd5cb] bg-white px-4 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" name="tipo" id="tipo" required>
                <option value="">Selecione uma opção</option>
                <option value="Tradicional">Tradicional</option>
                <option value="Vegetariano">Vegetariano</option>
            </select>
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-bold text-[#294a3b]">Acompanhamento</span>
            <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="text" name="acompanhamento" id="acompanhamento" placeholder="Opcional">
        </label>

        <div class="grid gap-3 border-t border-[#e7ebe4] pt-4 sm:col-span-2 sm:grid-cols-2">
            <label class="flex cursor-pointer items-center gap-3 rounded-lg bg-[#f6f8f4] px-4 py-3 text-sm font-semibold text-[#39584a]">
                <input class="h-4 w-4 accent-[#174b3a]" type="checkbox" name="presenca" value="1">
                Presença já confirmada
            </label>
            <label class="flex cursor-pointer items-center gap-3 rounded-lg bg-[#f6f8f4] px-4 py-3 text-sm font-semibold text-[#39584a]">
                <input class="h-4 w-4 accent-[#174b3a]" type="checkbox" name="pagamento" value="1">
                Pagamento já realizado
            </label>
        </div>

        <div class="flex flex-col-reverse gap-2 border-t border-[#e7ebe4] pt-4 sm:col-span-2 sm:flex-row sm:justify-end">
            <a href="listar.php" class="inline-flex items-center justify-center rounded-lg border border-[#cbd5cb] px-5 py-3 text-sm font-bold text-[#39584a] transition hover:bg-[#f6f8f4]">Cancelar</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#174b3a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#103b2d]">Salvar inscrição</button>
        </div>
    </form>

    </section>

<?php include_once '../includes/rodape.php'; ?>