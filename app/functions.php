<?php

function carregarTarefas() {
    if (file_exists('tarefas.json')) {
        return json_decode(file_get_contents('tarefas.json'), true);
    }
    return [];
}

function salvarTarefas($tarefas) {
    file_put_contents('tarefas.json', json_encode($tarefas, JSON_PRETTY_PRINT));
}