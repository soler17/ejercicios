<h1>Basesssssssss de datos de alumnos del instituto</h1>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

<?php


$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION
//var_dump ($conn);//nos devuelve la conexion que realiza

if($conn->connect_errno!=0){//nos muestra el mensaje si ha habido un error a la hora de conectar, por ejemplo porque la contraseña este mal escriba, o que la base de datos no este conectada.
  echo '¡Conexion con la base de datos fallida!';
}

$sql = "INSERT INTO alumno (nombre_alumno, apellidos_alumno, fecha_nacimiento, foto) VALUES ('" . $_POST["nombre_alumno"] . "' , '" . $_POST["apellidos_alumno"] . "' , '" . $_POST["fecha_nacimiento"] . "' , '" . $_FILES["archivo"] [name] .  "')";
//var_dump ($sql);//añadir nuevo alumno a la tabla de la base de datos
$conn->query($sql);

$sql = "SELECT * FROM alumno";
//var_dump ($sql);
$result = $conn->query($sql);

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


while ($fila = $result->fetch_assoc()){ 
  echo '<tr>';
    echo '<td style="text-align:center">' . $fila['id'] . '</td>';
    echo '<td style="text-align:center">' . $fila['nombre_alumno'] . '</td>';
    echo '<td style="text-align:center">' . $fila['apellidos_alumno'] . '</td>';
    echo '<td style="text-align:center">' . $fila['fecha_nacimiento'] . '</td>';
  echo '</tr>';

}

move_uploaded_file($_FILES['archivo'] ['tmp_name'], '/tmp/hola.jpg');

echo '</tbody>';
echo '</table>';

$conn->close();


?>
