<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


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
    //$db = new PDO('mysql:host=mysql.hostinger.es;dbname=u133033580_cole;charset=utf8','u133033580_ubu','123456');//conexion a la BdD REMOTA
    $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries

    echo '<h2>Realizado correctamente el alta del nuevo alumno.</h2>';

    $nombreArchivo = md5(uniqid());

    //var_dump($_FILES);
    move_uploaded_file($_FILES['foto'] ['tmp_name'], 'uploads/'. $nombreArchivo . '.jpg');//a la hora de que suban la foto, queremos que se mueva a nuestro servidor


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
        if (isset($_POST['actividad_extra'])){

        $ultimoIdInsertado = $db->lastInsertId();
        
        $sql = "INSERT INTO alumno_actividad_extra
                (alumno_id, actividad_extra_id)
                VALUES
                (?, ?)
        ";
        //insertamos las actividades extras asociadas al alumno
          foreach ($_POST['actividad_extra'] as $nuevaActividadesAlumno) {
            $st = $db->prepare($sql);
            $st->execute(array($ultimoIdInsertado, $nuevaActividadesAlumno));
          }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return FALSE;
    }

  ?>

    <button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
    Ir a formulario</button>
    <button onclick="location.href='lista_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
    Ir a lista de alumnos</button>
    

  </div>
</body>
</html>

