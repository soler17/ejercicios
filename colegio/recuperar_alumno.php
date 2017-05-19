Hola
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries


$sql = "SELECT nombre_alumno, apellidos_alumno, fecha_nacimiento FROM alumno";
var_dump($sql);
try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}
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
            echo '<th style="text-align:center; text-transform: capitalize">' . str_replace('_', ' ',   $nombreColumna). '</th>';
        }
    }
    //echo '<th>Acciones</th>';
    echo '</tr>';
echo '</thead>';

echo '<tbody>';
    echo '<tr>';
    foreach ($primeraFila as $clave => $elementoPrimeraFila) {
        if ($clave == 'fecha_nacimiento') { 
            echo '<td style="text-align:center">' . date("d-m-Y", strtotime($elementoPrimeraFila)) . '</td>';  
        } else {    
            echo '<td style="text-align:center">' . $elementoPrimeraFila . '</td>';
        }
    }
    //echo '<td style="text-align:center"><a href="editar_alumno.php?id=' . $primeraFila['id'] . '">Editar</a>';
    echo '<br>';
    //echo '<a href="editar_alumno.php">Eliminar</a></td>';
    echo '</tr>';


//while ($fila = $result->fetch_assoc()){ //while con mysqli
while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
  echo '<tr>';
    //echo '<td style="text-align:center">' .$fila['id']. '</td>';
    echo '<td style="text-align:center">' .$fila['nombre_alumno']. '</td>';
    echo '<td style="text-align:center">' .$fila['apellidos_alumno']. '</td>';
    echo '<td style="text-align:center">' .date("d-m-Y", strtotime($fila['fecha_nacimiento'])). '</td>';
   // echo '<td style="text-align:right">' .number_format($fila['nota_media'], 2, ',', '.'). '</td>';
   // echo '<td style="text-align:center">' .$fila['curso_id']. '</td>';
    //echo '<td style="text-align:center"><img src = "uploads/' .$fila['foto_alumno']. '"> </td>';
    //echo '<td style="text-align:center"><a href="editar_alumno.php?id=' .$fila['id']. '">Editar</a>';
   // echo '<br>';
  //  echo '<a href="eliminar_alumno.php?id=' .$fila['id'].'">Eliminar</a></td>';
  echo '</tr>';

}
?>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries


$sql = "SELECT fecha_nacimiento, apellidos_alumno, nombre_alumno  FROM alumno";
var_dump ($sql);        
try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}

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
            echo '<th style="text-align:center; text-transform: capitalize">' . str_replace('_', ' ',   $nombreColumna). '</th>';
        }
    }
    //echo '<th>Acciones</th>';
    echo '</tr>';
echo '</thead>';

echo '<tbody>';
    echo '<tr>';
    foreach ($primeraFila as $clave => $elementoPrimeraFila) {
        if ($clave == 'fecha_nacimiento') { 
            echo '<td style="text-align:center">' . date("d-m-Y", strtotime($elementoPrimeraFila)) . '</td>';  
        } else {    
            echo '<td style="text-align:center">' . $elementoPrimeraFila . '</td>';
        }
    }
    //echo '<td style="text-align:center"><a href="editar_alumno.php?id=' . $primeraFila['id'] . '">Editar</a>';
    echo '<br>';
    //echo '<a href="editar_alumno.php">Eliminar</a></td>';
    echo '</tr>';


//while ($fila = $result->fetch_assoc()){ //while con mysqli
while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
  echo '<tr>';
    //echo '<td style="text-align:center">' .$fila['id']. '</td>';
    echo '<td style="text-align:center">' .$fila['nombre_alumno']. '</td>';
    echo '<td style="text-align:center">' .$fila['apellidos_alumno']. '</td>';
    echo '<td style="text-align:center">' .date("d-m-Y", strtotime($fila['fecha_nacimiento'])). '</td>';
    //echo '<td style="text-align:right">' .number_format($fila['nota_media'], 2, ',', '.'). '</td>';
    //echo '<td style="text-align:center">' .$fila['curso_id']. '</td>';
   // echo '<td style="text-align:center"><img src = "uploads/' .$fila['foto_alumno']. '"> </td>';
   // echo '<td style="text-align:center"><a href="editar_alumno.php?id=' .$fila['id']. '">Editar</a>';
    echo '<br>';
   // echo '<a href="eliminar_alumno.php?id=' .$fila['id'].'">Eliminar</a></td>';
  echo '</tr>';

}
