<?php
try{
    $conn = new mysqli("localhost", "root", "", "churrasco");
}
catch(mysqli_sql_exception $e){
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>