<?php 
    include('actions/session.php');
    include('actions/connection.php'); 
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">CodeBet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php
                $usuarioId = $_SESSION['usuario_id'];
                $sql = "SELECT saldo FROM saldo WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuarioId);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $saldo = $resultado->num_rows > 0 ? $resultado->fetch_assoc()['saldo'] : "00.00";
                ?>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Saldo: R$ <?php echo number_format($saldo, 2, ',', '.'); ?></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="actions/logout.php">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
