<?php
include('../header.php'); // já inclui a conexão e a sessão

// Verifica se a requisição é para atualizar o saldo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateSaldo') {
    $usuarioId = $_SESSION['usuario_id']; // Obtém o ID do usuário da sessão
    $valor = floatval($_POST['valor']); // Valor pode ser positivo (ganho) ou negativo (perda)

    // Busca o saldo atual do usuário
    $stmt = $conn->prepare("SELECT saldo FROM saldo WHERE id_usuario = ?");
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $saldoAtual = $resultado->fetch_assoc()['saldo'];
        $novoSaldo = $saldoAtual + $valor; // Atualiza o saldo

        // Atualiza o saldo no banco de dados
        $stmtUpdate = $conn->prepare("UPDATE saldo SET saldo = ? WHERE id_usuario = ?");
        $stmtUpdate->bind_param("di", $novoSaldo, $usuarioId);
        if ($stmtUpdate->execute()) {
            echo json_encode(['success' => true, 'message' => 'Saldo atualizado com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o saldo.']);
        }
    } else {
        // Trata o caso de não encontrar o usuário (pode inserir um saldo inicial se necessário)
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minerador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Adicionando animações -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .game-cell {
            transition: all 0.3s ease-in-out;
        }
        .game-cell:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body style="background-color: #343a40">

<div class="container py-5">
    <!-- Elemento de saldo -->
    <div class="saldo-container d-flex align-items-center justify-content-between bg-dark text-light px-4 py-2 rounded text-center mx-auto" style="max-width: 400px; background-color: #495057;">
        <div class="d-flex align-items-center">
            <i class="bi bi-cash-stack text-warning me-2" style="font-size: 1.5rem;"></i> <!-- Ícone de saldo do Bootstrap -->
            <span class="saldo-valor" style="font-size: 1.2rem;">Saldo: R$ <?php echo $saldo; ?></span>
        </div>
    </div>
    
    <div class="card text-center mx-auto text-white mb-3 shadow" style="max-width: 400px; background-color: #495057">
        <div class="card-body">
            <h5 class="card-title">Minerador</h5>
            <input type="number" id="apostaValue" placeholder="Insira sua aposta" required class="form-control mb-2">
            <select id="bombasValue" class="form-select mb-2">
                <option value="5">5 Bombas</option>
                <option value="10">10 Bombas</option>
                <option value="15">15 Bombas</option>
                <option value="20">20 Bombas</option>
                <option value="24">24 Bombas</option>
            </select>
            <!-- Elemento para exibir o ganho potencial -->
            <div id="ganhoPotencial" class="mb-2 text-light">Ganho Potencial: R$0</div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary animate__animated animate__bounceIn" onclick="startGame()">Começar</button><br>
            </div>
        </div>
    </div>

    <div class="card text-center mx-auto text-white mb-3 shadow" id="gameArea" style="display: none; max-width: 320px; background-color: #495057">
        <div class="card-body">
            <div class="row justify-content-center">
                <!-- Criação de 25 células (5x5) para o jogo -->
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <?php for($i = 0; $i < 25; $i++): ?>
                        <!-- Ajuste no estilo das células para se ajustarem em uma grade 5x5 -->
                        <div class="p-2 m-1 bg-secondary game-cell shadow" style="width: calc(20% - 10px); height: 50px; line-height: 50px; text-align: center;"></div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let gameActive = false;
let bombas = 5;
let bombIndexes = [];
let ganhoPotencial = 0; // Declarado globalmente

function startGame() {
    const aposta = parseFloat(document.getElementById('apostaValue').value);
    bombas = parseInt(document.getElementById('bombasValue').value, 10);
    ganhoPotencial = aposta; // Inicializa o ganho potencial com o valor da aposta

    if (isNaN(aposta) || aposta <= 0) {
        alert('Por favor, insira um valor de aposta válido.');
        return;
    }

    gameActive = true;
    document.getElementById('gameArea').style.display = 'block';
    bombIndexes = generateBombIndexes(bombas, 25);
    activateGameCells(); // Atualizado para não passar ganhoPotencial como argumento
}

function activateGameCells() {
    const cells = document.querySelectorAll('.game-cell');
    let safeClicks = 0;
    const aposta = parseFloat(document.getElementById('apostaValue').value);
    let finalizarJogadaButtonAdded = false; // Variável para controlar se o botão de finalizar jogada foi adicionado

    cells.forEach((cell, index) => {
        cell.onclick = function() {
            if (!gameActive || cell.classList.contains('bg-success') || cell.classList.contains('bg-danger')) return;

            if (bombIndexes.includes(index)) {
                cell.classList.replace('bg-secondary', 'bg-danger');
                cell.innerHTML = '💣';
                gameActive = false;
                revealAllBombs();
                finishGame(false, aposta); // Perde a aposta original se atingir uma bomba
            } else {
                cell.classList.replace('bg-secondary', 'bg-success');
                cell.innerHTML = '💎';
                safeClicks++;
                ganhoPotencial += ganhoPotencial * 0.05; // Aumenta o ganho potencial em 5%
                document.getElementById('ganhoPotencial').innerText = `Ganho Potencial: R$${ganhoPotencial.toFixed(2)}`;
                if (!finalizarJogadaButtonAdded) {
                    // Cria uma div para conter o botão
                    const divContainer = document.createElement('div');
                    divContainer.classList.add('d-grid', 'gap-2');
                    
                    // Adiciona o botão de finalizar jogada na div
                    const finalizarJogadaButton = document.createElement('button');
                    finalizarJogadaButton.innerText = 'Finalizar Jogada';
                    finalizarJogadaButton.classList.add('btn', 'btn-warning', 'btn-block');
                    finalizarJogadaButton.onclick = function() {
                        finishGame(true, ganhoPotencial); // Envia o ganho potencial atualizado
                    };
                    divContainer.appendChild(finalizarJogadaButton);
                    
                    // Adiciona a div no local desejado (dentro da card-body)
                    document.querySelector('.card-body').appendChild(divContainer);
                    finalizarJogadaButtonAdded = true;
                }
                if (safeClicks === cells.length - bombas) {
                    gameActive = false;
                    revealAllBombs();
                    finishGame(true, ganhoPotencial); // Envia o ganho potencial atualizado
                }
            }
        };
    });
}

function finishGame(userWon, voluntary = false) {
    let aposta = parseFloat(document.getElementById('apostaValue').value);
    let valorFinal;

    if (userWon) {
        // Se o jogador ganhou, o valor final é o ganho potencial menos o valor da aposta inicial.
        valorFinal = ganhoPotencial - aposta;
    } else {
        // Se o jogador perdeu ou finalizou voluntariamente, o valor final é apenas o negativo da aposta inicial.
        valorFinal = voluntary ? -aposta : 0;
    }

    fetch('<?php echo $_SERVER["PHP_SELF"]; ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=updateSaldo&valor=${valorFinal}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        setTimeout(() => {
            window.location.reload();
        }, 1000); // Atraso de 1 segundo antes de recarregar a página
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Houve um erro.');
        setTimeout(() => {
            window.location.reload();
        }, 1000); // Atraso de 1 segundo antes de recarregar a página em caso de erro
    });
}

function revealAllBombs() {
    const cells = document.querySelectorAll('.game-cell');
    cells.forEach((cell, index) => {
        if (bombIndexes.includes(index) && !cell.classList.contains('bg-danger')) {
            cell.classList.replace('bg-secondary', 'bg-warning');
            cell.innerHTML = '💣'; // Mostra a bomba
        }
    });
}

function generateBombIndexes(bombCount, totalCells) {
    let indexes = new Set();
    while (indexes.size < bombCount) {
        let randomIndex = Math.floor(Math.random() * totalCells);
        indexes.add(randomIndex);
    }
    return [...indexes];
}

</script>
</body>
</html>
