<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = 'library';

$conn = mysqli_connect($servidor, $usuario, $contrasena) or die ("No se conecto al servidor");

$db = mysqli_select_db($conn, $basededatos) or die ("No se conecto a la base");
?>
