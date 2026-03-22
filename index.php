<?php

// =========================
// 📥 CARREGAR JSON
// =========================
if (file_exists('tarefas.json')) {
    $tarefas = json_decode(file_get_contents('tarefas.json'), true);
} else {
    $tarefas = [];
}

// =========================
// ⚙️ AÇÕES (GET)
// =========================
$acao = $_GET['acao'] ?? null;
$id = $_GET['id'] ?? null;

if ($acao && $id !== null && isset($tarefas[$id])) {

    if ($acao === 'concluir') {
        $tarefas[$id]['status'] = 'concluida';
    }

    if ($acao === 'remover') {
        unset($tarefas[$id]);
        $tarefas = array_values($tarefas);
    }

    // salva após ação
    file_put_contents('tarefas.json', json_encode($tarefas, JSON_PRETTY_PRINT));

    // evita repetir ação ao atualizar página
    header("Location: index.php");
    exit;
}

// =========================
// ➕ ADICIONAR (POST)
// =========================
// ADICIONAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['editar_id'])) {

    $novaTarefa = $_POST['titulo'] ?? '';

    if (!empty($novaTarefa)) {

        $existe = false;

        foreach ($tarefas as $tarefa) {
            if (strtolower($tarefa['titulo']) === strtolower($novaTarefa)) {
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $tarefas[] = [
                "titulo" => $novaTarefa,
                "status" => "pendente"
            ];
        }
    }

    file_put_contents('tarefas.json', json_encode($tarefas, JSON_PRETTY_PRINT));

    header("Location: index.php");
    exit;
}

$id = $_GET['editar_id'] ?? null;
$tarefaEditando = null;

if ($id !== null && isset($tarefas[$id])) {
    $tarefaEditando = $tarefas[$id];
}

// =========================
// 💾 SALVAR EDIÇÃO (POST)
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
    $id = $_POST['editar_id'];
    $novoTitulo = $_POST['titulo'] ?? '';

    if (isset($tarefas[$id]) && !empty($novoTitulo)) {
        $tarefas[$id]['titulo'] = $novoTitulo;
        file_put_contents('tarefas.json', json_encode($tarefas, JSON_PRETTY_PRINT));
    }

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

    <div class="container py-5">

        <h1 class="mb-4">🚀 Gerenciador de Tarefas</h1>

        <!-- FORM -->
        <form method="POST" class="d-flex gap-2 mb-4">

            <?php if ($tarefaEditando): ?>
                <input type="hidden" name="editar_id" value="<?= $id ?>">
            <?php endif; ?>

            <input
                type="text"
                name="titulo"
                class="form-control"
                placeholder="Digite uma tarefa"
                value="<?= $tarefaEditando['titulo'] ?? '' ?>">

            <button type="submit" class="btn btn-<?= $tarefaEditando ? 'warning' : 'success' ?>">
                <?= $tarefaEditando ? 'Atualizar' : 'Adicionar' ?>
            </button>


        </form>

        <!-- LISTA -->
        <div class="card bg-secondary">
            <div class="card-body">
                <h4 class="mb-3">Lista de Tarefas</h4>

                <ul class="list-group list-group-flush">
                    <?php foreach ($tarefas as $index => $tarefa): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">

                            <span>
                                <strong><?= $tarefa['titulo'] ?></strong>
                                <span class="badge bg-<?= $tarefa['status'] === 'pendente' ? 'warning' : 'success' ?>">
                                    <?= $tarefa['status'] ?>
                                </span>
                            </span>

                            <div class="d-flex gap-2">
                                <?php if ($tarefa['status'] === 'pendente'): ?>
                                    <a href="?acao=concluir&id=<?= $index ?>" class="btn btn-sm btn-primary">
                                        ✔
                                    </a>
                                <?php endif; ?>

                                <a
                                    href="?acao=remover&id=<?= $index ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja remover?')">
                                    ✖
                                </a>
                                <a href="?editar_id=<?= $index ?>" class="btn btn-sm btn-warning">
                                    ✏️
                                </a>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>

    </div>

</body>

</html>