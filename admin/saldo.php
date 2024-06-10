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
    <h2 class="text-white mb-4">Usuários:</h2>
    <div class="row">
        <?php
        include('actions/connection.php');

        $sql = "SELECT usuarios.id, usuarios.nome, usuarios.sobrenome, IFNULL(saldo.saldo, 0) AS saldo 
                FROM usuarios 
                LEFT JOIN saldo ON usuarios.id = saldo.id_usuario";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="card bg-dark text-white mb-3">
                        <div class="card-header">
                            <h5 class="card-title">
                                <?= $row["nome"] . " " . $row["sobrenome"] ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Saldo: R$ <?= number_format($row["saldo"], 2, ',', '.') ?></p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href='saldo_detalhes.php?id=<?= $row["id"] ?>' class="btn btn-light">Adicionar Saldo</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <p class='text-white'>Nenhum usuário encontrado.</p>
            <?php
        }

        $conn->close();
        ?>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
