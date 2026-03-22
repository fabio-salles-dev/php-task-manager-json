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
                <input type="hidden" name="editar_id" value="<?= $editarId ?>">
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

        <div class="row mb-4">

            <div class="col">
                <div class="card bg-info text-dark text-center p-3">
                    <h5>Total</h5>
                    <h3><?= $total ?></h3>
                </div>
            </div>

            <div class="col">
                <div class="card bg-warning text-dark text-center p-3">
                    <h5>Pendentes</h5>
                    <h3><?= $pendentes ?></h3>
                </div>
            </div>

            <div class="col">
                <div class="card bg-success text-center p-3">
                    <h5>Concluídas</h5>
                    <h3><?= $concluidas ?></h3>
                </div>
            </div>

        </div>

        <div class="mb-3 d-flex gap-2">

            <a href="index.php" class="btn btn-light">Todas</a>

            <a href="?status=pendente" class="btn btn-warning">
                Pendentes
            </a>

            <a href="?status=concluida" class="btn btn-success">
                Concluídas
            </a>

        </div>

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