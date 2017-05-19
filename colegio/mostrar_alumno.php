<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM alumno WHERE id = 3";

try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}


$primeraFila = $st->fetch(PDO::FETCH_ASSOC);
var_dump($primeraFila);

echo '<table>';

echo '<thead>';
echo '<tr>';
echo '<th style="text-align:center">Campo</th>';
echo '<th style="text-align:center">Datos_alumno</th>';   

echo '</tr>';
echo '</thead>';

echo '<tbody>';


foreach ($primeraFila as $clave => $elementoPrimeraFila) {
    echo '<tr>';
    echo '<td>' . $clave . '</td>';
    echo '<td style="text-align:center">' . $elementoPrimeraFila . '</td>';
    echo '</tr>';
}
echo '</tbody>';

echo '</table>';


?>
