 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

<h1>Buscador de provincias</h1>


<?php


$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION
//var_dump ($conn);//nos devuelve la conexion que realiza

if($conn->connect_errno!=0){//nos muestra el mensaje si ha habido un error a la hora de conectar, por ejemplo porque la contraseña este mal escriba, o que la base de datos no este conectada.
  echo '¡Conexion con la base de datos fallida!';
}
$sql = "SELECT * FROM provincia";
//var_dump ($sql);
$result = $conn->query($sql);
//var_dump ($result);

echo '<form action="nuevo.php" method="post">';
echo '<label>Seleccione provincia: </label>';
echo '<select name="provincia" style="cursor: pointer; margin-left: 10px">';

while ($fila = $result->fetch_assoc()){

 echo '<option value="' . $fila['id'] .'"> ' . $fila['nombre'] . '</option>';//hacemos que nos cree el value por defecto de cada option a traves de $fila['id'], que nos lo mostrara si inspeccionamos el select. y despues nos mostrara el nombre de cada provincia con $fila['nombre']

}
echo '</select>';
echo '<input type="submit" value="Entrar" style="cursor: pointer; margin-left: 10px">';
echo '</form>';


$conn->close();

?>

