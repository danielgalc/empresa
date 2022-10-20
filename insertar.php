<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>

<body>
    <?php

    require 'auxiliar.php';

    $codigo = obtener_post('codigo');
    $denominacion = obtener_post('denominacion');
    $error = [];

    if (isset($codigo, $denominacion)) {
        // Validacion código:
        $long = mb_strlen($codigo);
        if ($long >= 1 && $long <= 2){
            // Todos los caracteres son dígitos:
            if(ctype_digit($codigo)){
                // El código no está repetido:
                $pdo = conectar();
                $sent = $pdo->prepare("SELECT COUNT(*) FROM departamentos WHERE codigo = :codigo");
                $sent->execute([':codigo' => $codigo]);
                $cuantos = $sent->fetchColumn();
                if($cuantos === 0){
                    // El código es válido

                } else {
                    $error[] = 'El código ya existe.';
                }
            } else {
                $error[] = 'Los caracteres no son válidos';
            }
        } else {
            $error[] = 'La longitud del código es incorrecta';
        }

        // Validación denominación:

        $long = mb_strlen($denominacion);
        if ($long >= 1 && $long <= 255){
            // La denominación es válida.
        } else {
            $error[] = 'La longitud de la denominación es incorrecta';
        }
        
        
        if (empty($error)){
            $pdo = conectar();
            $sent = $pdo->prepare("INSERT INTO departamentos (codigo, denominacion) VALUES (:codigo, :denominacion)");
            $sent->execute([':codigo' => $codigo, ':denominacion' => $denominacion]);
            return volver();
        }
    }


    ?>
    <div>
        <form action="" method="post">
            <div>
                <label>
                    Código:
                    <input type="text" name="codigo">
                </label>
            </div>
            <div>
                <label>
                    Denominación:
                    <input type="text" name="denominacion">
                </label>
            </div>
            <div>
                <button type="submit">Insertar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>