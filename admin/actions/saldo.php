<?php
include('connection.php'); 

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario_id'], $_POST['valor'])) {
    $usuarioId = $_POST['usuario_id'];
    $valor = $_POST['valor'];

    // Prepara a consulta para verificar se o usuário já possui um saldo
    $sqlVerifica = "SELECT saldo FROM saldo WHERE id_usuario = ?";
    $stmtVerifica = $conn->prepare($sqlVerifica);
    $stmtVerifica->bind_param("i", $usuarioId);
    $stmtVerifica->execute();
    $resultadoVerifica = $stmtVerifica->get_result();

    if ($resultadoVerifica->num_rows > 0) {
        // Atualiza o saldo existente
        $saldoExistente = $resultadoVerifica->fetch_assoc();
        $novoSaldo = $saldoExistente['saldo'] + $valor;
        $sqlAtualiza = "UPDATE saldo SET saldo = ? WHERE id_usuario = ?";
        $stmtAtualiza = $conn->prepare($sqlAtualiza);
        $stmtAtualiza->bind_param("di", $novoSaldo, $usuarioId);
    } else {
        // Insere novo saldo
        $sqlInsere = "INSERT INTO saldo (id_usuario, saldo) VALUES (?, ?)";
        $stmtAtualiza = $conn->prepare($sqlInsere);
        $stmtAtualiza->bind_param("id", $usuarioId, $valor);
    }

    // Executa a consulta de atualização ou inserção
    if ($stmtAtualiza->execute()) {
        // Redireciona de volta para a página de detalhes do usuário
        header("Location: ../saldo_detalhes.php?id=$usuarioId");
        exit();
    } else {
        // Mantém na página em caso de erro, opcionalmente pode passar um parâmetro para indicar falha
        header("Location: ../saldo_detalhes.php?id=$usuarioId&error=true");
        exit();
    }
} else {
    // Se o formulário não foi enviado corretamente, redireciona de volta
    header("Location: ../saldo_detalhes.php?error=form");
    exit();
}
?>
