<?php
// config/database.php

$db_host = 'localhost';
$db_name = 'php_puro';
$db_user = 'root'; // Reemplaza 'usuario' por el nombre de usuario de tu base de datos
$db_pass = ''; // Reemplaza 'contraseña' por la contraseña de tu base de datos

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
