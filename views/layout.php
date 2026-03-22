<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>Task Manager</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body.light-mode {
            background: #f1f5f9;
            color: #111;
        }

        body.light-mode .card-custom {
            background: #ffffff;
        }

        body.light-mode .task-item {
            background: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
        }

        .card-custom {
            border-radius: 16px;
            background: #1e293b;
            border: none;
        }

        .btn-custom {
            border-radius: 10px;
        }

        .task-item {
            background: #0f172a;
            border-radius: 10px;
            padding: 12px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">🚀 Task Manager</h2>

            <button onclick="toggleTheme()" class="btn btn-outline-light">
                🌙 / ☀️
            </button>
        </div>

        <!-- FORM -->
        <form method="POST" class="d-flex gap-2 mb-4">
            <?php if ($tarefaEditando): ?>
                <input type="hidden" name="editar_id" value="<?= $editarId ?>">
            <?php endif; ?>

            <input
                type="text"
                name="titulo"
                class="form-control bg-dark text-white border-0"
                placeholder="Digite uma tarefa..."
                value="<?= $tarefaEditando['titulo'] ?? '' ?>">

            <button class="btn btn-<?= $tarefaEditando ? 'warning' : 'success' ?> btn-custom">
                <?= $tarefaEditando ? 'Atualizar' : 'Adicionar' ?>
            </button>
            <?php if ($tarefaEditando): ?>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            <?php endif; ?>
        </form>

        <!-- DASHBOARD -->
        <div class="row mb-4">
            <div class="col">
                <div class="card card-custom p-3 text-center text-white">
                    <small>Total</small>
                    <h3><?= $total ?></h3>
                </div>
            </div>

            <div class="col">
                <div class="card bg-warning p-3 text-center">
                    <small>Pendentes</small>
                    <h3><?= $pendentes ?></h3>
                </div>
            </div>

            <div class="col">
                <div class="card bg-success p-3 text-center text-white">
                    <small>Concluídas</small>
                    <h3><?= $concluidas ?></h3>
                </div>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="mb-4 d-flex gap-2">
            <a href="index.php" class="btn btn-light btn-custom">Todas</a>
            <a href="?status=pendente" class="btn btn-warning btn-custom">Pendentes</a>
            <a href="?status=concluida" class="btn btn-success btn-custom">Concluídas</a>
        </div>

        <!-- LISTA -->
        <div class="card card-custom p-3">

            <?php foreach ($tarefas as $index => $tarefa): ?>
                <div class="task-item d-flex justify-content-between align-items-center mb-2">

                    <div>
                        <strong class="text-white"><?= $tarefa['titulo'] ?></strong>
                        <br>
                        <span class="badge bg-<?= $tarefa['status'] === 'pendente' ? 'warning' : 'success' ?>">
                            <?= $tarefa['status'] ?>
                        </span>
                    </div>

                    <div class="d-flex gap-2">

                        <?php if ($tarefa['status'] === 'pendente'): ?>
                            <a href="?acao=concluir&id=<?= $index ?>" class="btn btn-sm btn-primary">
                                ✔
                            </a>
                        <?php endif; ?>

                        <a href="?editar_id=<?= $index ?>" class="btn btn-sm btn-warning">
                            ✏️
                        </a>

                        <a
                            href="?acao=remover&id=<?= $index ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Remover tarefa?')">
                            ✖
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
<div class="toast align-items-center text-bg-success border-0" id="liveToast">
    <div class="d-flex">
        <div class="toast-body">
            <?= $_SESSION['mensagem'] ?>
        </div>
    </div>
</div>

    <script>
        function toggleTheme() {
            document.body.classList.toggle('light-mode');

            // salva preferência
            localStorage.setItem('theme', document.body.classList.contains('light-mode') ? 'light' : 'dark');
        }

        // carregar tema salvo
        window.onload = function() {
            if (localStorage.getItem('theme') === 'light') {
                document.body.classList.add('light-mode');
            }
        }
    </script>

    <script>
window.onload = function () {

    // tema
    if (localStorage.getItem('theme') === 'light') {
        document.body.classList.add('light-mode');
    }

    // toast
    const toastEl = document.getElementById('liveToast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
            delay: 3000
        });
        toast.show();
    }
};
</script>

</body>

</html>