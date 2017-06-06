<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.3.3/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
      "lengthMenu": [ 5, 10, 30, 40 ],
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

//$conn = new mysqli('localhost','root','ubuntu', "colegio"); //REALIZA LA CONEXION con mysqli
//var_dump ($conn);//nos devuelve la conexion que realiza


$sql = "SELECT
    alumno.id,
    alumno.nombre_alumno AS nombre_alumno,
    alumno.apellidos_alumno,
    alumno.fecha_nacimiento,
    alumno.nota_media,  
    curso.nombre AS nombre_curso,
    alumno.foto_alumno
FROM alumno
JOIN curso ON alumno.curso_id=curso.id";

//var_dump ($sql);

try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
} 

setlocale(LC_TIME, 'es_ES.UTF-8');
echo strftime("%A %d de %B del %Y")
?>
  <table id="myTable" class="display compact" cellspacing="0" width="100%">

 <?php $primeraFila = $st->fetch(PDO::FETCH_ASSOC);
//var_dump ($primeraFila);//nos devuelve la primera fila de la tabla
    $nombreColumnas = array_keys($primeraFila); ?>


    <thead>
      <tr>
      <?php foreach ($nombreColumnas as $nombreColumna) { 
      if ($nombreColumna == 'curso_id'){ ?>
        <th style="text-align:center"><?php echo str_replace('curso_id', 'curso',   $nombreColumna) ?></th>
      <?php } else{ ?>
        <th style="text-align:center; text-transform: capitalize"><?php echo str_replace('_', ' ',   $nombreColumna) ?></th>
      <?php }
    } ?>
        <th>Acciones</th>
      </tr>
    </thead>

    <tbody>
      <tr>
    <?php foreach ($primeraFila as $clave => $elementoPrimeraFila) {
      if ($clave == 'fecha_nacimiento') { ?>
        <td style="text-align:center"><?php echo date("d-m-Y", strtotime($elementoPrimeraFila)) ?></td>
      <?php } else if ($clave == 'nota_media') { ?>
        <td style="text-align:right"><?php echo $nota_media = number_format($elementoPrimeraFila, 2, ',', '.')?></td>
      <?php } else if ($clave == 'foto_alumno') { ?>
        <td style="text-align:center"><img src="uploads/<?php echo $elementoPrimeraFila ?>"></td>
      <?php } else { ?>   
        <td style="text-align:center"><?php echo $elementoPrimeraFila ?></td>
      <?php }
    } ?>
        <td style="text-align:center">
          <a href="editar_alumno.php?id=<?php echo $primeraFila['id'] ?>" class="fa fa-pencil" aria-hidden="true">Editar</a>
          <br>
          <a href="eliminar_alumno.php?id=<?php echo $primeraFila['id'] ?>" class="eliminar fa fa-trash" aria-hidden="true">Eliminar</a>
        </td>
      </tr>



    <?php while ($fila = $st->fetch(PDO::FETCH_ASSOC)){ ?>
      <tr>
        <td style="text-align:center"><?php echo $fila['id'] ?></td>
        <td style="text-align:center"><?php echo $fila['nombre_alumno'] ?></td>
        <td style="text-align:center"><?php echo $fila['apellidos_alumno'] ?></td>
        <td style="text-align:center"><?php echo date("d-m-Y", strtotime($fila['fecha_nacimiento'])) ?></td>
        <td style="text-align:right"><?php echo number_format($fila['nota_media'], 2, ',', '.') ?></td>
        <td style="text-align:center"><?php echo $fila['nombre_curso'] ?> </td>
        <td style="text-align:center"><img src = "uploads/<?php echo $fila['foto_alumno'] ?>"></td>
        <td style="text-align:center"><a href="editar_alumno.php?id= <?php echo $fila['id'] ?>"<i class="fa fa-pencil" aria-hidden="true"></i>Editar</a>
        <br>
        <a  href="eliminar_alumno.php?id=<?php echo $fila['id'] ?>" class="eliminar fa fa-trash" aria-hidden="true">Eliminar</a></td>
      </tr>
    <?php } ?>


    </tbody>
  </table>

    <button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success" style="cursor: pointer">
    Ir a formulario</button>

</div>
    
  <script>
    $('.eliminar').on('click', function(){
      return confirm('¿Esta seguro de que quiere borrar el alumno?');
    });
  </script>

</body>
</html>


