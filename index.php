<?php
require_once 'includes/verificar_login.php';
require_once 'config/conexao.php';
include_once 'includes/cabecalho.php';

$total_inscritos = $conn->query("SELECT COUNT(*) FROM participantes")->fetch_row()[0];

$confirmados = $conn->query("SELECT COUNT(*) FROM participantes WHERE confirmado = 1")->fetch_row()[0];
$nao_confirmados = $conn->query("SELECT COUNT(*) FROM participantes WHERE confirmado = 0")->fetch_row()[0];

$pagos = $conn->query("SELECT COUNT(*) FROM participantes WHERE pago = 1")->fetch_row()[0];
$pendentes = $conn->query("SELECT COUNT(*) FROM participantes WHERE pago = 0")->fetch_row()[0];

$tradicional = $conn->query("SELECT COUNT(*) FROM participantes WHERE tipo_churrasco = 'Tradicional'")->fetch_row()[0];
$vegetariano = $conn->query("SELECT COUNT(*) FROM participantes WHERE tipo_churrasco = 'Vegetariano'")->fetch_row()[0];
?>

<h2>CHURRASCO DA SEMANA FARROUPILHA</h2>

<div class="resumo-cards">
    <div class="card destaque">
        <h3>Total de inscritos</h3>
        <p class="numero"><?= $total_inscritos ?></p>
    </div>

    <div class="card-grupo">
        <div class="card">
            <h3>Confirmados</h3>
            <p class="numero ok"><?= $confirmados ?></p>
        </div>
        <div class="card">
            <h3>Não confirmados</h3>
            <p class="numero aviso"><?= $nao_confirmados ?></p>
        </div>
    </div>

    <div class="card-grupo">
        <div class="card">
            <h3>Pagamentos realizados</h3>
            <p class="numero ok"><?= $pagos ?></p>
        </div>
        <div class="card">
            <h3>Pagamentos pendentes</h3>
            <p class="numero erro"><?= $pendentes ?></p>
        </div>
    </div>

    <div class="card-grupo">
        <div class="card">
            <h3>Churrasco tradicional</h3>
            <p class="numero"><?= $tradicional ?></p>
        </div>
        <div class="card">
            <h3>Vegetariano</h3>
            <p class="numero"><?= $vegetariano ?></p>
        </div>
    </div>
</div>

<div class="acoes-iniciais">
    <a href="participantes/cadastrar.php" class="btn btn-principal">Nova Inscrição</a>
    <a href="participantes/listar.php" class="btn btn-secundario">Participantes</a>
    <a href="auth/logout.php" class="btn btn-perigo">Sair</a>
</div>

<?php include_once 'includes/rodape.php'; ?>