<html>

<head>

<meta charset="utf-8">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>


</head>


<body>

<div class="container" style="padding-top:50px">
<?php

$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION
//var_dump ($conn);//nos devuelve la conexion que realiza

if($conn->connect_errno!=0){//nos muestra el mensaje si ha habido un error a la hora de conectar, por ejemplo porque la contraseña este mal escriba, o que la base de datos no este conectada.
  echo '¡Conexion con la base de datos fallida!';
}

echo '<h2>Realizado correctamente el alta del nuevo alumno.</h2>';


$sql = "INSERT INTO alumno (nombre_alumno, apellidos_alumno, fecha_nacimiento, curso_id) VALUES ('" . $_POST["nombre_alumno"] . "' , '" . $_POST["apellidos_alumno"] . "' , '" . $_POST["fecha_nacimiento"] .  "' , '" . $_POST["curso_id"] .  "')"; 

// "' , '" . $_FILES["archivo"] [name] .
//var_dump ($sql);//añadir nuevo alumno a la tabla de la base de datos

$conn->query($sql);

?>

<button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
     Ir a formulario</button>
<button onclick="location.href='lista_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
     Ir a lista de alumnos</button>


</div>


</body>
</html>

