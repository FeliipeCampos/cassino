<?php
session_start();

include('connection.php'); 

// Recebe os dados do formulário
$email = $_POST['email'];
$senha = $_POST['password'];

// Prepara a consulta
$sql = "SELECT id, senha, nome FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        // Senha correta, armazena dados do usuário na sessão
        $_SESSION['usuario_id'] = $row['id']; 
        $_SESSION['usuario_nome'] = $row['nome'];
        $_SESSION['logado'] = true; 

        // Redireciona para index.php
        header("Location: ../index.php");
        exit;
    } else {
        // Senha incorreta
        echo "Senha incorreta!";
    }
} else {
    // Email não encontrado
    echo "Email não encontrado!";
}

$stmt->close();
$conn->close();
?>
