<?php
try{
    $conn = new mysqli("localhost", "root", "", "churrasco");
    $conn->set_charset("utf8");
}
catch(mysqli_sql_exception $e){
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>