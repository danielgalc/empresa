<?php

function conectar(){
    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}

function volver(){
    header("Location: index.php");
}