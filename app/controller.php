<?php

require_once __DIR__ . '/functions.php';

$tarefas = carregarTarefas();

// GET
$acao = $_GET['acao'] ?? null;
$id = $_GET['id'] ?? null;

// CONCLUIR / REMOVER
if ($acao && $id !== null && isset($tarefas[$id])) {

    if ($acao === 'concluir') {
        $tarefas[$id]['status'] = 'concluida';
    }

    if ($acao === 'remover') {
        unset($tarefas[$id]);
        $tarefas = array_values($tarefas);
    }

    salvarTarefas($tarefas);
    header("Location: index.php");
    exit;
}

// EDITAR GET
$editarId = $_GET['editar_id'] ?? null;
$tarefaEditando = $editarId !== null && isset($tarefas[$editarId])
    ? $tarefas[$editarId]
    : null;

$total = count($tarefas);

$pendentes = 0;
$concluidas = 0;

foreach ($tarefas as $tarefa) {
    if ($tarefa['status'] === 'pendente') {
        $pendentes++;
    } else {
        $concluidas++;
    }
}

// FILTRO
$filtro = $_GET['status'] ?? null;

if ($filtro) {
    $tarefas = array_filter($tarefas, function ($tarefa) use ($filtro) {
        return $tarefa['status'] === $filtro;
    });

    $tarefas = array_values($tarefas);
}

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'] ?? '';

    // EDITAR
    if (isset($_POST['editar_id'])) {

        $id = $_POST['editar_id'];

        if (isset($tarefas[$id]) && !empty($titulo)) {
            $tarefas[$id]['titulo'] = $titulo;
        }

    } else {
        // ADICIONAR
        if (!empty($titulo)) {

            $existe = false;

            foreach ($tarefas as $tarefa) {
                if (strtolower($tarefa['titulo']) === strtolower($titulo)) {
                    $existe = true;
                    break;
                }
            }

            if (!$existe) {
                $tarefas[] = [
                    "titulo" => $titulo,
                    "status" => "pendente"
                ];
            }
        }
    }

    salvarTarefas($tarefas);
    header("Location: index.php");
    exit;

}