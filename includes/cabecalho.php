<?php
$script_path = $_SERVER['SCRIPT_NAME'] ?? '';
$app_base = (str_contains($script_path, '/participantes/') || str_contains($script_path, '/auth/')) ? '../' : '';
$autenticado = isset($_SESSION['email']);
$titulo_pagina = $titulo_pagina ?? 'Churrasco Farroupilha';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#174b3a">
	<title><?= htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8') ?> | Semana Farroupilha</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					fontFamily: {
						sans: ['DM Sans', 'sans-serif'],
						display: ['Fraunces', 'serif']
					},
					colors: {
						campo: '#174b3a',
						brasa: '#bd4a2f',
						palha: '#f6f2e9'
					}
				}
			}
		};
	</script>
</head>
<body class="min-h-screen bg-[#f6f2e9] font-sans text-[#1e3029] antialiased">
	<header class="border-b border-[#d9dfd5] bg-white/95">
		<div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-5 py-4 sm:px-8">
			<a href="<?= $app_base ?>index.php" class="flex items-center gap-3" aria-label="Ir ao painel">
				<span class="grid h-11 w-11 place-items-center rounded-xl bg-[#174b3a] font-display text-sm font-bold text-white">SF</span>
				<span>
					<span class="block font-display text-lg leading-tight text-[#174b3a]">Semana Farroupilha</span>
					<span class="text-xs font-semibold uppercase tracking-[0.12em] text-[#78847b]">Gestão do churrasco</span>
				</span>
			</a>
			<?php if ($autenticado): ?>
				<nav class="flex flex-wrap items-center gap-2 text-sm font-semibold" aria-label="Navegação principal">
					<a class="rounded-lg px-3 py-2 text-[#39584a] transition hover:bg-[#edf3ee] hover:text-[#174b3a]" href="<?= $app_base ?>index.php">Painel</a>
					<a class="rounded-lg px-3 py-2 text-[#39584a] transition hover:bg-[#edf3ee] hover:text-[#174b3a]" href="<?= $app_base ?>participantes/listar.php">Participantes</a>
					<a class="rounded-lg bg-[#bd4a2f] px-4 py-2 text-white transition hover:bg-[#a83d26]" href="<?= $app_base ?>participantes/cadastrar.php">Nova inscrição</a>
					<a class="rounded-lg px-3 py-2 text-[#768078] transition hover:bg-[#fbefec] hover:text-[#a83d26]" href="<?= $app_base ?>auth/logout.php">Sair</a>
				</nav>
			<?php endif; ?>
		</div>
	</header>
	<main class="mx-auto min-h-[calc(100vh-150px)] max-w-7xl px-5 py-8 sm:px-8 sm:py-10">
