<?php include('header.php');?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="text-white mb-4">Detalhes do Saldo</h2>
    <?php
    include('actions/connection.php');

    $usuarioId = isset($_GET['id']) ? $_GET['id'] : 0;

    $sql = "SELECT id_usuario, saldo FROM saldo WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $saldo = $resultado->fetch_assoc();
    ?>
        <p class='text-white'>ID do Usuário: <?= $saldo['id_usuario'] ?></p>
        <p class='text-white'>Saldo: R$ <?= number_format($saldo['saldo'], 2, ',', '.') ?></p>
    <?php
    } else {
    ?>
        <p class='text-white'>Saldo não encontrado para o usuário.</p>
    <?php
    }
    ?>

    <div class="card bg-dark text-white mt-4">
        <div class="card-body">
            <h5 class="card-title">Adicionar Saldo</h5>
            <form action="actions/saldo.php" method="post">
                <input type="hidden" name="usuario_id" value="<?= $usuarioId ?>">
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                </div>
                <button type="submit" class="btn btn-light">Adicionar</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
