<html>

<head>

<meta charset="utf-8">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.3.3/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
    
    <style>
        #myTable_wrapper{
            margin-top: 30px;
        }
        img{
            width: 80px;
        }
    </style>
    

</head>


<body>

<div class="container">
<h1 style="padding-top:30px">Base de datos de alumnos del instituto</h1>
    
    
    
    

     <script>
$(document).ready(function () {
                $.fn.dataTable.moment( 'DD-MM-YYYY' );
                $('#myTable').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "lengthMenu": [ 10, 20, 30, 40 ],
                    "colReorder": true
		 });
});
</script>



<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries

//$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION con mysqli
//var_dump ($conn);//nos devuelve la conexion que realiza


$sql = "SELECT * FROM alumno";
//var_dump ($sql);

try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}

//$result = $db->query($sql);
//var_dump ($result);



//for($i=0; $i<3; $i++){
  //var_dump($result->fetch_assoc());
//}

setlocale(LC_TIME, 'es_ES.UTF-8');
echo strftime("%A %d de %B del %Y");

echo '<table id="myTable" class="display compact" cellspacing="0" width="100%"  >';
//$primeraFila = $result->fetch_assoc();
 $primeraFila = $st->fetch(PDO::FETCH_ASSOC);
//var_dump ($primeraFila);//nos devuelve la primera fila de la tabla
$nombreColumnas = array_keys($primeraFila);
//var_dump ($nombreColumnas);//nos devuelve el array de la cabecera

echo '<thead>';
echo '<tr>';
foreach ($nombreColumnas as $nombreColumna) {
    if ($nombreColumna == 'curso_id'){
        echo '<th style="text-align:center">' . str_replace('curso_id', 'curso',   $nombreColumna). '</th>';
    } else{
  echo '<th style="text-align:center; text-transform: capitalize"">' . str_replace('_', ' ',   $nombreColumna). '</th>';
    }
}
echo '</tr>';
echo '</thead>';

echo '<tbody>';
echo '<tr>';
foreach ($primeraFila as $clave => $elementoPrimeraFila) {
  if ($clave == 'fecha_nacimiento') { 
    echo '<td style="text-align:center">' . date("d-m-Y", strtotime($elementoPrimeraFila)) . '</td>';  
} else if ($clave == 'nota_media') {
        echo '<td style="text-align:right">' . 
             $nota_media = number_format($elementoPrimeraFila, 2, ',', '.') . 
             '</td>';
} else if ($clave == 'foto_alumno') {
        echo '<td style="text-align:center"> <img src = "uploads/' . $elementoPrimeraFila . '"> </td>';
} else {
    echo '<td style="text-align:center">' . $elementoPrimeraFila . '</td>'; 
}
} 
echo '</tr>';


//while ($fila = $result->fetch_assoc()){ //while con mysqli
while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
  echo '<tr>';
    echo '<td style="text-align:center">' . $fila['id'] . '</td>';
    echo '<td style="text-align:center">' . $fila['nombre_alumno'] . '</td>';
    echo '<td style="text-align:center">' . $fila['apellidos_alumno'] . '</td>';
    echo '<td style="text-align:center">' . date("d-m-Y", strtotime($fila['fecha_nacimiento'])) . '</td>';
    echo '<td style="text-align:right">' . number_format($fila['nota_media'], 2, ',', '.') . '</td>';
    echo '<td style="text-align:center">' . $fila['curso_id'] . '</td>';
    echo '<td style="text-align:center"> <img src = "uploads/' . $fila['foto_alumno'] . '"> </td>';
  echo '</tr>';

}





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



//$db->close();


?>

<button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
     Ir a formulario</button>

</div>


</body>
</html>


