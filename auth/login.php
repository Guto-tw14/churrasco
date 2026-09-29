<?php
$titulo_pagina = 'Entrar';
include_once '../includes/cabecalho.php';
?>
<section class="mx-auto grid max-w-5xl overflow-hidden rounded-2xl border border-[#d9dfd5] bg-white shadow-sm md:grid-cols-2">
    <div class="relative flex min-h-64 flex-col justify-between overflow-hidden bg-[#174b3a] p-7 text-white sm:p-10 md:min-h-[440px]">
        <div class="relative">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#e8b99c]">Semana Farroupilha</p>
            <h1 class="mt-5 max-w-sm font-display text-4xl leading-tight sm:text-5xl">Churrasco dos guris.</h1>
        </div>
        <p class="relative mt-10 max-w-xs text-sm leading-6 text-white/75">Acesse o painel para acompanhar inscrições, presenças e pagamentos do churrasco.</p>
    </div>
    <div class="flex flex-col justify-center p-7 sm:p-10">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#bd4a2f]">Área da organização</p>
        <h2 class="mt-2 font-display text-3xl text-[#174b3a]">Entrar</h2>
        <p class="mt-2 text-sm text-[#68766d]">Use sua conta para continuar.</p>
        <form class="mt-8 space-y-5" action="autenticar.php" method="POST">
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-[#294a3b]">E-mail</span>
                <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition placeholder:text-[#9aa49d] focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="email" name="email" autocomplete="username" placeholder="nome@exemplo.com" required>
            </label>
            <label class="block">
                <span class="mb-2 block text-sm font-bold text-[#294a3b]">Senha</span>
                <input class="w-full rounded-lg border border-[#cbd5cb] px-4 py-3 text-sm outline-none transition placeholder:text-[#9aa49d] focus:border-[#174b3a] focus:ring-4 focus:ring-[#174b3a]/10" type="password" name="senha" autocomplete="current-password" placeholder="Sua senha" required>
            </label>
            <button class="w-full rounded-lg bg-[#bd4a2f] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#a83d26]" type="submit">Acessar painel</button>
        </form>
    </div>
</section>
<?php include_once '../includes/rodape.php'; ?>