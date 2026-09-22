<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
include_once '../includes/cabecalho.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM participantes WHERE id = :id");
$stmt->execute([':id' => $id]);
$p = $stmt->fetch();

if (!$p) {
    echo "<p>Participante não encontrado!</p>";
    include_once '../includes/rodape.php';
    exit;
}
?>

<h2>Editar Participante</h2>

<form action="atualizar.php" method="POST">
    <input type="hidden" name="id" value="<?= $p['id'] ?>">

    <div>
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($p['nome']) ?>" required>
    </div><br>

    <div>
        <label for="turma">Turma:</label><br>
        <input type="text" name="turma" id="turma" value="<?= htmlspecialchars($p['turma']) ?>" required>
    </div><br>

    <div>
        <label for="telefone">Telefone:</label><br>
        <input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($p['telefone']) ?>">
    </div><br>

    <div>
        <label for="tipo_churrasco">Tipo de Churrasco:</label><br>
        <select name="tipo_churrasco" id="tipo_churrasco" required>
            <option value="Tradicional" <?= $p['tipo_churrasco'] === 'Tradicional' ? 'selected' : '' ?>>Tradicional</option>
            <option value="Vegetariano" <?= $p['tipo_churrasco'] === 'Vegetariano' ? 'selected' : '' ?>>Vegetariano</option>
        </select>
    </div><br>

    <div>
        <label for="acompanhamento">Acompanhamento:</label><br>
        <input type="text" name="acompanhamento" id="acompanhamento" value="<?= htmlspecialchars($p['acompanhamento']) ?>">
    </div><br>

    <div>
        <label>Presença Confirmada?</label><br>
        <input type="radio" name="confirmado" value="1" <?= $p['confirmado'] ? 'checked' : '' ?>> Sim
        <input type="radio" name="confirmado" value="0" <?= !$p['confirmado'] ? 'checked' : '' ?>> Não
    </div><br>

    <div>
        <label>Pagamento Realizado?</label><br>
        <input type="radio" name="pago" value="1" <?= $p['pago'] ? 'checked' : '' ?>> Sim
        <input type="radio" name="pago" value="0" <?= !$p['pago'] ? 'checked' : '' ?>> Não
    </div><br>

    <button type="submit">Salvar Alterações</button>
    <a href="listar.php">Cancelar</a>
</form>

<?php include_once '../includes/rodape.php'; ?>