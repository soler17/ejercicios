<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>

    
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
<h1 style="padding-top:30px">Se ha modificado correctamente el alumno</h1>
    
    
    
    

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

//$db = new PDO('mysql:host=mysql.hostinger.es;dbname=u133033580_cole;charset=utf8','u133033580_ubu','123456');//conexion a la BdD REMOTA
$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries y conexion a la BdD LOCAL
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries

$nuevasActividadesAlumno = isset($_POST['actividad_extra']) ? 
    $_POST['actividad_extra'] : array();
$sql = "SELECT actividad_extra_id 
       FROM alumno_actividad_extra
       WHERE alumno_id= ?
       ";
try{
  $st = $db->prepare($sql);
  $st->execute(array($_GET['id']));
  } catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
  }
$antiguasActividadesAlumno = $st->fetchAll(PDO::FETCH_COLUMN);
var_dump($antiguasActividadesAlumno);

$actividadesAnadidas = array_diff($nuevasActividadesAlumno, $antiguasActividadesAlumno);
$actividadesEliminadas = array_diff($antiguasActividadesAlumno, $nuevasActividadesAlumno);
var_dump($actividadesEliminadas);
var_dump($actividadesAnadidas);

foreach ($actividadesAnadidas as $actividadAnadida) {
  $sql = "INSERT INTO alumno_actividad_extra
    (alumno_id, actividad_extra_id)
    VALUES
    (?, ?)
  ";
    
  try{
    $st = $db->prepare($sql);
    $st->execute(array($_GET['id'], $actividadAnadida));
  } catch (PDOException $e) {
      echo $e->getMessage();
      return FALSE;
  }
}



foreach ($actividadesEliminadas as $actividadEliminada) {
  $sql = "DELETE FROM alumno_actividad_extra
    WHERE alumno_id=? AND actividad_extra_id=?
    ";
    
  try{
    $st = $db->prepare($sql);
    $st->execute(array($_GET['id'], $actividadEliminada));
  } catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
  }
}

if ($_FILES['foto'] ['error'] == 4){
    $cadenaColumnaFoto = '';
} else{
  $nombreArchivo = md5(uniqid());
  move_uploaded_file($_FILES['foto'] ['tmp_name'], 'uploads/'.$nombreArchivo . ".jpg" );//a la hora de que suban la foto, queremos que se mueva a nuestro servidor
  $cadenaColumnaFoto = ", foto_alumno = '" .$nombreArchivo . ".jpg'";
}

//$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION con mysqli
//var_dump ($conn);//nos devuelve la conexion que realiza
$sql = "update alumno
  set nombre_alumno='" .$_POST['nombre_alumno']. "' , 
    ". "apellidos_alumno='" .$_POST['apellidos_alumno']. "' ,
    ". "fecha_nacimiento='" .date("Y-m-d", strtotime($_POST['fecha_nacimiento'])). "' ,
    ". "nota_media='" .str_replace(',', '.', $_POST['nota_media']). "' ,
    ". "curso_id='" .$_POST['curso_id']. "'". 
    $cadenaColumnaFoto .
  "where id=" .$_POST['id']. ";"
;


try{
  $st = $db->prepare($sql);
  $st->execute();
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



