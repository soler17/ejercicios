<html>

<head>

<meta charset="utf-8">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>


</head>


<body>

<div class="container">
<h1 style="padding-top:30px">Base de datos de alumnos del instituto</h1>
    
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
       

     <script>
//$(document).ready(function () {
//                $('#myTable').DataTable({
//                    "language": {
//                        "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
//                    },
//                    "lengthMenu": [ 2, 4, 6, 8 ]
//		 });
//});
</script>



<?php

$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION
//var_dump ($conn);//nos devuelve la conexion que realiza


$sql = "SELECT * FROM alumno";
//var_dump ($sql);
$result = $conn->query($sql);
//var_dump ($result);



//for($i=0; $i<3; $i++){
  //var_dump($result->fetch_assoc());
//}

echo '<table id="myTable" class="table table-striped">';
$primeraFila = $result->fetch_assoc();
//var_dump ($primeraFila);//nos devuelve la primera fila de la tabla
$nombreColumnas = array_keys($primeraFila);
//var_dump ($nombreColumnas);//nos devuelve el array de la cabecera

echo '<thead>';
echo '<tr>';
foreach ($nombreColumnas as $nombreColumna) {
  echo '<th style="text-align:center">' . $nombreColumna. '</th>';
}
echo '</tr>';
echo '</thead>';

echo '<tbody>';
echo '<tr>';
foreach ($primeraFila as $elementosPrimeraFila) {
  echo '<td style="text-align:center">' . $elementosPrimeraFila. '</td>';
}
echo '</tr>';
setlocale (LC_TIME, "es_ES");
echo strftime("%A %d de %B del %Y");
while ($fila = $result->fetch_assoc()){ 
  echo '<tr>';
    echo '<td style="text-align:center">' . $fila['id'] . '</td>';
    echo '<td style="text-align:center">' . $fila['nombre_alumno'] . '</td>';
    echo '<td style="text-align:center">' . $fila['apellidos_alumno'] . '</td>';
    echo '<td style="text-align:center">' . date("d-m-Y", strtotime($fila['fecha_nacimiento'])) . '</td>';

    //echo (string date ( string $format [, int $timestamp = time( d m Y) ] ));
    echo '<td style="text-align:center">' . $fila['curso_id'] . '</td>';
    echo '<td style="text-align:center">' . $fila['foto'] . '</td>';
  echo '</tr>';

}


//var_dump($_FILES);
move_uploaded_file($_FILES['archivo'] ['tmp_name'], '/tmp/hola.jpg'); //a la hora de que suban la foto, queremos que se mueva a nuestro servidor
//var_dump($_GET);//nos devuelve el nuevo nombre introducido en nuevosalumnos.html


//Añadir dato a array indexado
////$dias = array ('lunes', 'martes', 'miercoles' );
//$dias [] = 'jueves'; //añado el nuevo dato
//foreach ($dias as $clave => $dia){
  //echo $clave . ' ' . $dia . '<br>';
//}
//var_dump ($dias);

//Añadir dato a array asociativo
//$edades = array ('lunes' => 28, 'martes' => 46, 'miercoles' => 30 );
//$edades ['jueves'] = 62;//añado el nuevo dato
//foreach ($edades as $clave => $edad){
  //echo $clave . ' ' . $edad . '<br>';
  //echo $clave;
  //echo $edad . ' ';
//}
//var_dump ($edades);


//var_dump($result->fetch_assoc());
//var_dump($result->fetch_assoc());

echo '</tbody>';
echo '</table>';



$conn->close();


?>

<button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
     Ir a formulario</button>

</div>


</body>
</html>


