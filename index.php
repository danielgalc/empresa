<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <?php 
    
    $codigo = (isset($_GET['codigo'])) ? trim($_GET['codigo']) : null;
    $codigo2 = (isset($_GET['codigo2'])) ? trim($_GET['codigo2']) : null;

    ?>

    <div>
        <form action="" method="get">
            <label>
                Desde código:
                <input type="text" name="codigo" size="8" value="<?= $codigo ?>">
            </label>
            <label>
                Hasta código:
                <input type="text" name="codigo2" size="8" value="<?= $codigo2 ?>">
            </label>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $pdo->beginTransaction();
    $sent = $pdo->query("LOCK TABLE departamentos IN SHARE MODE");
    $sent = $pdo->prepare('SELECT COUNT(*) FROM departamentos WHERE codigo >= :codigo AND codigo <= :codigo2');
    $sent->execute([':codigo' => $codigo, ':codigo2' => $codigo2]); 
    $total = $sent->fetchColumn();
    $sent = $pdo->prepare('SELECT * FROM departamentos WHERE codigo >= :codigo AND codigo <= :codigo2 ORDER BY codigo');
    $sent->execute([':codigo' => $codigo, ':codigo2' => $codigo2]);
    $pdo->commit(); 
    ?>

    <div>
        <table style="margin:auto" border="1">
            <thead>
                <th>Código</th>
                <th>Denominación</th>
            </thead>
            <tbody>
                <?php foreach($sent as $fila): ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['denominacion'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <p>Número total de filas: <?= $total ?></p>
    </div>
</body>
</html>