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
    $desde_codigo = (isset($_GET['desde_codigo'])) ? trim($_GET['desde_codigo']) : null;
    $hasta_codigo = (isset($_GET['hasta_codigo'])) ? trim($_GET['hasta_codigo']) : null;
    $denom = (isset($_GET['denom'])) ? trim($_GET['denom']) : null;
    ?>
    <div>
        <form action="" method="get">
            <fieldset>
                <legend>Criterios de búsqueda</legend>
                <p>
                    <label>
                        Desde código:
                        <input type="text" name="desde_codigo" size="8" value="<?= $desde_codigo ?>">
                    </label>
                </p>
                <p>
                    <label>
                        Hasta código:
                        <input type="text" name="hasta_codigo" size="8" value="<?= $hasta_codigo ?>">
                    </label>
                </p>
                <p>
                    <label>
                        Denominación:
                        <input type="text" name="denom" value="<?= $denom ?>">
                    </label>
                </p>
                <button type="submit">Buscar</button>
            </fieldset>
        </form>
    </div>
    <?php
        if($denom == "" && $desde_codigo == "" && $hasta_codigo == ""){
            $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
            $pdo->beginTransaction();
            $sent = $pdo->query('SELECT COUNT(*) FROM departamentos');
            $total = $sent->fetchColumn();
            $sent = $pdo->query('SELECT * FROM departamentos');
        } else {
            $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
            $pdo->beginTransaction();
            $sent = $pdo->query('LOCK TABLE departamentos IN SHARE MODE');
            $sent = $pdo->prepare('SELECT COUNT(*)
                                     FROM departamentos
                                    WHERE codigo BETWEEN :desde_codigo AND :hasta_codigo AND denominacion = :denom');    
            $sent->execute([
                ':desde_codigo' => $desde_codigo,
                ':hasta_codigo' => $hasta_codigo,
                ':denom' => $denom
            ]);
            $total = $sent->fetchColumn();
            $sent = $pdo->prepare('SELECT *
                                     FROM departamentos
                                    WHERE codigo BETWEEN :desde_codigo AND :hasta_codigo AND denominacion = :denom
                                 ORDER BY codigo');
            $sent->execute([
                ':desde_codigo' => $desde_codigo,
                ':hasta_codigo' => $hasta_codigo,
                ':denom' => $denom
            ]);
            $pdo->commit();
        }


    ?>
    <br>
    <div>
        <table style="margin: auto" border="1">
            <thead>
                <th>Código</th>
                <th>Denominación</th>
            </thead>
            <tbody>
                <?php                
                    foreach ($sent as $fila): ?>
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