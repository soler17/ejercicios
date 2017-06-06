<?php

$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a la BdD LOCAL
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries

$sql = "INSERT INTO contacto
        (nombre, apellidos, email, telefono, mensaje)
        VALUES
        (?, ?, ?, ?, ?)
";

try {
  $st = $db->prepare($sql);
  $st->execute(array($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['mensaje'],));
} catch(Exception $e) {
  echo $e->getMessage();
  return false;
}

