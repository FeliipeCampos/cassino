<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>área para testes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
        }
        .bg-custom-card {
            background-color: #495057; 
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card bg-custom-card text-white h-100">
                    <img src="imagens/aviaozinho.webp" class="card-img-top img-fluid" alt="Jogo Aviãozinho">
                    <div class="card-body">
                        <h5 class="card-title">Aviãozinho</h5>
                        <p class="card-text">Não deixa o aviãozinho cair, Ein! O elefantinho tem medo de altura.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="text-decoration-none">
                <div class="card bg-custom-card text-white h-100">
                    <img src="imagens/elefantinho.webp" class="card-img-top img-fluid" alt="Jogo Elefantinho">
                    <div class="card-body">
                        <h5 class="card-title">Elefantinho</h5>
                        <p class="card-text">Elefantinho paga demais!!! Vem encontrar o melhor horário!</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="jogos/minerador.php" class="text-decoration-none">
                <div class="card bg-custom-card text-white h-100">
                    <img src="imagens/minas.webp" class="card-img-top img-fluid" alt="Jogo Minerador">
                    <div class="card-body">
                        <h5 class="card-title">Minerador</h5>
                        <p class="card-text">Vem ajudar o elefantinho a minerar, aqui tá cheio de dima!</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
