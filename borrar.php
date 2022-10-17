<?php

require 'auxiliar.php';

$id = obtener_post('id');

if (!isset($id)){
    return volver();
}

$pdo = conectar();
$sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
$sent->execute([':id' => $id]);
return volver();