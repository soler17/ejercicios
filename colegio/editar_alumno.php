<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
      label{
          text-transform: capitalize;
          
      }
  </style>
<script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sab'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
 weekHeader: 'Sm',
 dateFormat: 'dd-mm-yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
    $("#calendario").datepicker({
        changeMonth: true,
        changeYear: true
    });
 
});
</script>

</head>


<body>


<header>
 <div class="container" style="padding-top: 20px">
   <h3>Editar alumno:</h3>
 </div>
</header>


<main>
    <div class="container" style="padding-top: 20px">
        <form action="modificar_alumno.php?id=<?php echo $_GET['id']?>" method="post" enctype="multipart/form-data">
    
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$db = new PDO('mysql:host=mysql.hostinger.es;dbname=u133033580_cole;charset=utf8','u133033580_ubu','123456');//conexion a la BdD REMOTA
$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries y conexion a la BdD LOCAL
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//seleccionamos/recuperamos el alumno que queremos editar
$sql = "SELECT * FROM alumno
        WHERE id = " .$_GET['id'];

try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}

$alumno = $st->fetch(PDO::FETCH_ASSOC);

//seleccionamos todas las actividades
$sql = "SELECT * FROM actividad_extra";
try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}

$actividadesExtra = $st->fetchAll(PDO::FETCH_ASSOC);
//var_dump($actividadesExtra);

//seleccionamos los id's de las actividades que realiza el alumno
$sql = "SELECT actividad_extra_id
        FROM alumno_actividad_extra 
        WHERE alumno_id = " .$_GET['id'];

      try{
        $st = $db->prepare($sql);
        $st->execute();
      } catch (PDOException $e) {
        echo $e->getMessage();
        return FALSE;
      }
      
$actividadesExtraAlumno = $st->fetchAll(PDO::FETCH_COLUMN);
//var_dump($actividadesExtraAlumno);
?>
      
 
      <div class="form-group row">
        <label>Nombre</label>
        <input type="date" class="form-control" name="nombre_alumno" value="<?php echo $alumno['nombre_alumno'] ?>"required>
      </div>
      <div class="form-group row">
        <label>Apellidos</label>
        <input type="date" class="form-control" name="apellidos_alumno" value="<?php echo $alumno['apellidos_alumno'] ?>"required>
      </div>
     <div class="form-group row">
        <label>Curso:</label>
        <?php $sql = "SELECT * FROM curso";

          try{
            $st = $db->prepare($sql);
            $st->execute();
          } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
          } ?>
                
        <select class="custom-select form-control" name="curso_id" style="cursor:pointer">

          <?php while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
            if($campoAlumno == $fila ['id']){ ?>
            <option value="<?php echo $fila['id'] ?>" selected="selected"><?php echo $fila['nombre'] ?></option>	  
            <?php } else { ?>
            <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre'] ?></option>	  

            <?php }
          } ?>
        </select> 
    </div>
      <div class="form-group row" style="display:none">
        <label>Id:</label>
        <input type="text" class="form-control" name="id" value="<?php echo $alumno['id'] ?>"required>
      </div>
      <div class="form-group row">
        <label>Fecha nacimiento:</label>
        <input type="text" id="calendario" class="form-control" style="cursor: pointer" name="fecha_nacimiento" value="<?php echo date("d-m-Y", strtotime($alumno['fecha_nacimiento'])) ?>"required>
      </div> 
      <div class="form-group row">
        <label>Nota media:</label>
        <input type="text" class="form-control" name="nota_media" value="<?php echo number_format($alumno['nota_media'],2, ',', '.') ?>"required>
      </div>
      <div class="form-group row">
        <label>Foto:</label>
        <img src="uploads/<?php echo $alumno['foto_alumno'] ?>">
      </div>
      <div class="form-group row">
        <label >Seleccione foto alumno: </label>
        <input type="file" name="foto" class="form-control-file col-10 col-sm-7 col-md-8 offset-1 offset-sm-0" id="exampleInputFile" aria-describedby="fileHelp" style="margin-top: 15px">
      </div>
      <div class="form-group row">
        <label style="padding-right: 30px">Actividad extra:</label>
      <?php foreach ($actividadesExtra as $actividadExtra) {?>
        <div class="col-6 col-sm-3 col-md-2 row">
          <label class="custom-control custom-checkbox"><?php echo $actividadExtra['nombre_actividad']?>
          <?php $estadoCheckbox = '';
          if (in_array($actividadExtra['id'], $actividadesExtraAlumno)) {
              $estadoCheckbox =' checked';
          }?>
          <input type="checkbox" class="custom-control-input" value="<?php echo $actividadExtra['id']?>" name="actividad_extra[]"<?php echo $estadoCheckbox ?>>
          <span class="custom-control-indicator"></span>
          </label>
        </div>    
      <?php 
        }
      ?>
      </div>
      <div class="form-group"> 
        <input type="submit" class="btn btn-info offset-md-1 offset-1" value="Enviar nuevo alumno" style="cursor:pointer">
      </div>
                 
      <button onclick="location.href='lista_alumno.php'" type="button" class="btn btn-success offset-md-1 offset-1" style="cursor: pointer">
        Ir a lista de alumnos</button>
           
    </form>

  </div>
</main>


</body>

</html>
      
