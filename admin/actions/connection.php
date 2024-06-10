<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "cassino";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Checando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
