<html>

<head>

<meta charset="utf-8">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>


</head>

<body>

<div class="container">
    <h1 style="margin-top:30px; padding: 20px; background-color:lightblue">Lista de móviles</h1>
    
<?php

$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries

$sql = "SELECT * FROM producto";

echo '<table id="myTable" class="table table-striped"  style="text-transform: capitalize">';
//$primeraFila = $result->fetch_assoc();
 $primeraFila = $st->fetch(PDO::FETCH_ASSOC);
//var_dump ($primeraFila);//nos devuelve la primera fila de la tabla
$nombreColumnas = array_keys($primeraFila);
//var_dump ($nombreColumnas);//nos devuelve el array de la cabecera

echo '<thead>';
echo '<tr>';
foreach ($nombreColumnas as $nombreColumna) {
    echo '<th style="text-align:center">' . str_replace('_', ' ',   $nombreColumna). '</th>';
    
}
echo '</tr>';
echo '</thead>';

echo '<tbody>';
echo '<tr>';
foreach ($primeraFila as $elementoPrimeraFila) {
    echo '<td style="text-align:center">' . $elementoPrimeraFila . '</td>'; 
} 
echo '</tr>';


//while ($fila = $result->fetch_assoc()){ //while con mysqli
while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
  echo '<tr>';
    echo '<td style="text-align:center">' . $fila['id'] . '</td>';
    echo '<td style="text-align:center">' . $fila['modelo'] . '</td>';
    echo '<td style="text-align:center">' . $fila['procesador'] . '</td>';
    echo '<td style="text-align:center">' . $fila['sistema_operativo'] . '</td>';
    echo '<td style="text-align:right">' .  $fila['memoria_interna'] . '</td>';
    echo '<td style="text-align:center">' . $fila['memoria_ram'] . '</td>';
    //echo '<td style="text-align:center">' . $fila['foto'] . '</td>';
  echo '</tr>';

}


echo '</tbody>';
echo '</table>';



?>

    </div>


</body>
</html>
