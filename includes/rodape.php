	</main>
	<footer class="border-t border-[#d9dfd5] bg-white">
		<div class="mx-auto flex max-w-7xl flex-col gap-1 px-5 py-5 text-xs text-[#78847b] sm:flex-row sm:items-center sm:justify-between sm:px-8">
			<span>Semana Farroupilha · Gestão de participantes</span>
			<?php if (isset($app_base)): ?>
				<a href="<?= $app_base ?>index.php" class="font-semibold text-[#174b3a] hover:text-[#bd4a2f]">Voltar ao painel</a>
			<?php endif; ?>
		</div>
	</footer>
</body>
</html>
