<?php
require_once '../includes/verificar_login.php';
require_once '../config/conexao.php';
require_once '../includes/cabecalho.php';

$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
$filtro_pago = isset($_GET['filtro_pago']) ? $_GET['filtro_pago'] : '';
$filtro_confirmado = isset($_GET['filtro_confirmado']) ? $_GET['filtro_confirmado'] : '';

$sql = "SELECT * FROM participantes WHERE nome LIKE :pesquisa";
$params = [];
if (!empty($pesquisa)) {
    $sql .= " AND nome LIKE :pesquisa";
    $params[':pesquisa'] = '%' . $pesquisa . '%';
} 
if (($filtro_pago === 'sim')) {
    $sql .= " AND pago = :filtro_pago";
    $params[':filtro_pago'] = 1;
} elseif (($filtro_pago === 'nao')) {
    $sql .= " AND pago = :filtro_pago";
    $params[':filtro_pago'] = 0;
}
if (($filtro_confirmado === 'sim')) {
    $sql .= " AND confirmado = :filtro_confirmado";
    $params[':filtro_confirmado'] = 1;
} elseif (($filtro_confirmado === 'nao')) {
    $sql .= " AND confirmado = :filtro_confirmado";
    $params[':filtro_confirmado'] = 0;
}

$sql .= " ORDER BY nome ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$participantes = $stmt->fetchAll();
?>

<h2>Lista de Participantes</h2>
<form method="GET" action="listar.php">
    <div>
        <label for="pesquisa">Pesquisar por nome:</label>
        <input type="text" name="pesquisa" id="pesquisa" value="<?php echo htmlspecialchars($pesquisa); ?>">
    </div>
        <form method="GET" action="listar.php">
            <div>
                <label for="pesquisa">Pesquisar participante:</label>
                <input type="text" name="pesquisa" id="pesquisa" value="<?php echo htmlspecialchars($pesquisa); ?>">
                <button type="submit">Pesquisar</button>
            </div>
            
            <div>
    </div>
    