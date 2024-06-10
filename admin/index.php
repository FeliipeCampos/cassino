<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
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
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Adicionar Saldo</h5>
                    <p class="card-text">Adicione saldo à conta de algum usuário.</p>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="saldo.php" class="btn btn-light">Adicionar agora</a>
                </div>
            </div>
        </div>
    <!--<div class="col">
            <div class="card bg-dark text-white h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Gerenciar usuários</h5>
                    <p class="card-text">Observe informações sigilosas dos usuários.</p>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="usuarios.php" class="btn btn-light">Visualizar</a>
                </div>
            </div>
        </div>-->
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
