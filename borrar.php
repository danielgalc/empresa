<?php

require 'auxiliar.php';

$id = obtener_post('id');

<<<<<<< HEAD
if (!isset($id)) {
    return volver();
}

// TODO: Validar id

$pdo = conectar();
$sent = $pdo->prepare("DELETE FROM departamentos WHERE id = :id");
$sent->execute([':id' => $id]);
volver();
=======
if (!isset($id)){
    return volver();
}

$pdo = conectar();
$sent = $pdo->prepare('DELETE FROM departamentos WHERE id = :id');
$sent->execute([':id' => $id]);
return volver();
>>>>>>> 91c1eeac01def8ef69624df24efa7d5e9349b769
