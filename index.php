<?php

echo "TESTE";
// =========================
// 📥 CARREGAR JSON
// =========================
if (file_exists('tarefas.json')) {
    $tarefas = json_decode(file_get_contents('tarefas.json'), true);
} else {
    $tarefas = [];
}

// =========================
// ➕ ADICIONAR
// =========================
$novaTarefa = "Aprender Arrays";

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

// =========================
// ✏️ UPDATE
// =========================
$indiceAtualizar = 0;

if (isset($tarefas[$indiceAtualizar])) {
    if ($tarefas[$indiceAtualizar]['status'] === 'pendente') {
        $tarefas[$indiceAtualizar]['status'] = 'concluida';
    }
}

// =========================
// ❌ DELETE
// =========================
$indiceRemover = 1;

if (isset($tarefas[$indiceRemover])) {
    unset($tarefas[$indiceRemover]);
    $tarefas = array_values($tarefas);
    $mensagemRemocao = "Tarefa removida com sucesso";
} else {
    $mensagemRemocao = "Índice inválido";
}

// =========================
// 💾 SALVAR JSON
// =========================
file_put_contents('tarefas.json', json_encode($tarefas, JSON_PRETTY_PRINT));

echo "<h1>Lista de Tarefas</h1>";
echo "<ul>";

foreach ($tarefas as $tarefa) {
    echo "<li>{$tarefa['titulo']} - {$tarefa['status']}</li>";
}
