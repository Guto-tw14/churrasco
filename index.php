<?php
require_once 'includes/verificar_login.php';
require_once 'config/conexao.php';
$titulo_pagina = 'Painel';
include_once 'includes/cabecalho.php';

$total_inscritos = $conn->query("SELECT COUNT(*) FROM participantes")->fetch_row()[0];

$confirmados = $conn->query("SELECT COUNT(*) FROM participantes WHERE confirmado = 1")->fetch_row()[0];
$nao_confirmados = $conn->query("SELECT COUNT(*) FROM participantes WHERE confirmado = 0")->fetch_row()[0];

$pagos = $conn->query("SELECT COUNT(*) FROM participantes WHERE pago = 1")->fetch_row()[0];
$pendentes = $conn->query("SELECT COUNT(*) FROM participantes WHERE pago = 0")->fetch_row()[0];

$tradicional = $conn->query("SELECT COUNT(*) FROM participantes WHERE tipo_churrasco = 'Tradicional'")->fetch_row()[0];
$vegetariano = $conn->query("SELECT COUNT(*) FROM participantes WHERE tipo_churrasco = 'Vegetariano'")->fetch_row()[0];
?>

<section class="mb-9 flex flex-col justify-between gap-6 border-b border-[#d9dfd5] pb-8 md:flex-row md:items-end">
    <div>
        <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-[#bd4a2f]">Resumo do evento</p>
        <h1 class="font-display text-3xl leading-tight text-[#174b3a] sm:text-4xl">Churrasco da Semana Farroupilha</h1>
        <p class="mt-3 max-w-xl text-sm leading-6 text-[#68766d]">Acompanhe inscrições, presenças e pagamentos em um só lugar.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="participantes/cadastrar.php" class="inline-flex items-center justify-center rounded-lg bg-[#bd4a2f] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#a83d26]">+ Nova inscrição</a>
        <a href="participantes/listar.php" class="inline-flex items-center justify-center rounded-lg border border-[#cbd5cb] bg-white px-5 py-3 text-sm font-bold text-[#174b3a] transition hover:bg-[#edf3ee]">Ver participantes</a>
    </div>
</section>

<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Indicadores do evento">
    <article class="rounded-xl border border-[#174b3a] bg-[#174b3a] p-5 text-white sm:col-span-2 xl:col-span-1">
        <p class="text-sm font-semibold text-white/75">Total de inscritos</p>
        <p class="mt-5 font-display text-5xl"><?= (int)$total_inscritos ?></p>
        <a href="participantes/listar.php" class="mt-5 inline-flex text-sm font-bold text-[#d6e7d8] underline decoration-white/40 underline-offset-4 hover:text-white">Abrir lista</a>
    </article>
    <article class="rounded-xl border border-[#d9dfd5] bg-white p-5">
        <p class="text-sm font-semibold text-[#68766d]">Presença</p>
        <div class="mt-5 flex items-end justify-between gap-3">
            <div><p class="font-display text-4xl text-[#174b3a]"><?= (int)$confirmados ?></p><p class="mt-1 text-xs font-semibold text-[#68766d]">confirmados</p></div>
            <div class="text-right"><p class="font-display text-2xl text-[#bd4a2f]"><?= (int)$nao_confirmados ?></p><p class="mt-1 text-xs font-semibold text-[#68766d]">pendentes</p></div>
        </div>
        <div class="mt-5 h-2 overflow-hidden rounded-full bg-[#f0e4dc]"><div class="h-full rounded-full bg-[#bd4a2f]" style="width: <?= $total_inscritos ? round($confirmados / $total_inscritos * 100) : 0 ?>%"></div></div>
    </article>
    <article class="rounded-xl border border-[#d9dfd5] bg-white p-5">
        <p class="text-sm font-semibold text-[#68766d]">Pagamentos</p>
        <div class="mt-5 flex items-end justify-between gap-3">
            <div><p class="font-display text-4xl text-[#174b3a]"><?= (int)$pagos ?></p><p class="mt-1 text-xs font-semibold text-[#68766d]">realizados</p></div>
            <div class="text-right"><p class="font-display text-2xl text-[#bd4a2f]"><?= (int)$pendentes ?></p><p class="mt-1 text-xs font-semibold text-[#68766d]">pendentes</p></div>
        </div>
        <div class="mt-5 h-2 overflow-hidden rounded-full bg-[#f0e4dc]"><div class="h-full rounded-full bg-[#174b3a]" style="width: <?= $total_inscritos ? round($pagos / $total_inscritos * 100) : 0 ?>%"></div></div>
    </article>
    <article class="rounded-xl border border-[#d9dfd5] bg-white p-5 sm:col-span-2 xl:col-span-1">
        <p class="text-sm font-semibold text-[#68766d]">Preferência de churrasco</p>
        <div class="mt-5 space-y-4">
            <div class="flex items-center justify-between"><span class="text-sm font-semibold">Tradicional</span><span class="font-display text-2xl text-[#174b3a]"><?= (int)$tradicional ?></span></div>
            <div class="h-px bg-[#e7ebe4]"></div>
            <div class="flex items-center justify-between"><span class="text-sm font-semibold">Vegetariano</span><span class="font-display text-2xl text-[#bd4a2f]"><?= (int)$vegetariano ?></span></div>
        </div>
    </article>
</section>

<section class="mt-10 grid gap-4 md:grid-cols-2">
    <a href="participantes/listar.php" class="group flex items-center justify-between rounded-xl border border-[#d9dfd5] bg-white p-5 transition hover:border-[#174b3a] hover:bg-[#fafffa]">
        <span><span class="block text-xs font-bold uppercase tracking-[0.14em] text-[#78847b]">Gerenciar</span><span class="mt-1 block font-display text-xl text-[#174b3a]">Participantes</span></span>
        <span class="text-2xl text-[#bd4a2f] transition group-hover:translate-x-1" aria-hidden="true">→</span>
    </a>
    <a href="participantes/cadastrar.php" class="group flex items-center justify-between rounded-xl border border-[#d9dfd5] bg-white p-5 transition hover:border-[#174b3a] hover:bg-[#fafffa]">
        <span><span class="block text-xs font-bold uppercase tracking-[0.14em] text-[#78847b]">Adicionar</span><span class="mt-1 block font-display text-xl text-[#174b3a]">Nova inscrição</span></span>
        <span class="text-2xl text-[#bd4a2f] transition group-hover:translate-x-1" aria-hidden="true">→</span>
    </a>
</section>

<?php include_once 'includes/rodape.php'; ?>