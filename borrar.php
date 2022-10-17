<?php

require 'auxiliar.php';

$id = isset($_POST['id']) ? trim(($_POST['id'])) : null;

if (!isset($id)){
    return volver();
}

$pdo = conectar();
$sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
$sent->execute([':id' => $id]);
return volver();