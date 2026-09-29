<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
include_once '../includes/cabecalho.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM participantes WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

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
        <label for="confirmado">Presença Confirmada?</label><br>
        <input type="hidden" name="confirmado" value="0">
        <input type="checkbox" name="confirmado" id="confirmado" value="1" <?= $p['confirmado'] ? 'checked' : '' ?>> Sim
    </div><br>

    <div>
        <label for="pago">Pagamento Realizado?</label><br>
        <input type="hidden" name="pago" value="0">
        <input type="checkbox" name="pago" id="pago" value="1" <?= $p['pago'] ? 'checked' : '' ?>> Sim
    </div><br>

    <button type="submit">Salvar Alterações</button>
    <a href="listar.php">Cancelar</a>
</form>

<?php include_once '../includes/rodape.php'; ?>