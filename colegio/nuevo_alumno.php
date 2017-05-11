<html>

<head>

<meta charset="utf-8">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    

</head>


<body>

<div class="container" style="padding-top:50px">
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION
//var_dump ($conn);//nos devuelve la conexion que realiza
$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries

//mysqli_set_charset($conn, 'utf8');//linea de codigo para visualizar los caracteres especiales


//if($db->connect_errno!=0){//nos muestra el mensaje si ha habido un error a la hora de conectar, por ejemplo porque la contraseña este mal escriba, o que la base de datos no este conectada.
  //echo '¡Conexion con la base de datos fallida!';
//}

echo '<h2>Realizado correctamente el alta del nuevo alumno.</h2>';

$nombreArchivo = md5(uniqid());

//var_dump($_FILES);
move_uploaded_file($_FILES['foto'] ['tmp_name'], 'uploads/'. $nombreArchivo . '.jpg');//a la hora de que suban la foto, queremos que se mueva a nuestro servidor
//var_dump($_GET);//nos devuelve el nuevo nombre introducido en nuevosalumnos.html

$sql = "INSERT INTO alumno (nombre_alumno, apellidos_alumno, fecha_nacimiento, nota_media, curso_id, foto_alumno)
        VALUES ('" . $_POST["nombre_alumno"] . "' ,
        '" . $_POST["apellidos_alumno"] . "' ,
        '" . date("Y-m-d", strtotime($_POST["fecha_nacimiento"])) .  "' ,
        '" . str_replace(',', '.', $_POST["nota_media"]) . "' ,  
        '" . $_POST["curso_id"] . "' , 
       '" . $nombreArchivo . '.jpg'."')"; 

try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}

// "' , '" . $_FILES["archivo"] [name] .
//var_dump ($sql);//añadir nuevo alumno a la tabla de la base de datos

//$conn->query($sql);


//$db->close();
?>

<button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
     Ir a formulario</button>
<button onclick="location.href='lista_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
     Ir a lista de alumnos</button>


</div>


</body>
</html>

