<html>

<head>

<meta charset="utf-8">

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
        <form action="modificar_alumno.php" method="post" enctype="multipart/form-data">
    

     
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM alumno WHERE id = " .$_GET['id'];

try{
    $st = $db->prepare($sql);
    $st->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
    return FALSE;
}


$camposAlumno = $st->fetch(PDO::FETCH_ASSOC);


foreach ($camposAlumno as $clave => $campoAlumno){
    if ($clave == 'curso_id'){
        echo '<div class="form-group row">';
            echo '<label >' . $clave . '</label>';
            $sql = "SELECT * FROM curso";

            try{
                $st = $db->prepare($sql);
                $st->execute();
            } catch (PDOException $e) {
               echo $e->getMessage();
               return FALSE;
            }


    //$result = $db->query($sql);
                
                echo '<select class="custom-select form-control" name="curso_id" style="cursor:pointer">';

          //echo '<option>Seleccione curso</option>';
          //while ($fila = $result->fetch_assoc()){

                    while ($fila = $st->fetch(PDO::FETCH_ASSOC)){

                //var_dump($fila);
                //var_dump($campoAlumno);

                if($campoAlumno == $fila ['id']){ 
                   echo '<option value="' . $fila['id'] . '" selected="selected">' . $fila['nombre'] . '</option>';	  
                } else {    
                   echo '<option value="' . $fila['id'] . '"> ' . $fila['nombre'] . '</option>';	  

                }
            }


                echo '</select>'; 
        echo '</div>';
    } else if ($clave == 'id'){
        echo '<div class="form-group row" style="display:none">';
            echo '<label >' . $clave . '</label>';
                echo '<input type="text" class="form-control" name="id" value="' . $campoAlumno . '"required>';
        echo '</div>';
    } else if ($clave == 'fecha_nacimiento'){
        echo '<div class="form-group row">';
            echo '<label >' . $clave . '</label>';
                echo '<input type="text" id="calendario" class="form-control" style="cursor: pointer" name="fecha_nacimiento" value="' . date("d-m-Y", strtotime($campoAlumno)) . '"required>';
        echo '</div>'; 
    } else if ($clave == 'foto_alumno'){ 
        echo '<div class="form-group row">';
            echo '<label> ' . $clave . '</label>';
                   echo '<img src="uploads/' . $campoAlumno . '">';
        echo '</div>'; 
    } else if ($clave == 'nota_media'){ 
        echo '<div class="form-group row">';
            echo '<label >' . $clave . '</label>';
                echo '<input type="text" class="form-control" name="nota_media" value="' . number_format($campoAlumno,2, ',', '.') . '"required>';
        echo '</div>'; 
    }else {
        echo '<div class="form-group row">';
            echo '<label >' . $clave . '</label>';
                echo '<input type="date"  class="form-control" name="' . $clave . '" value="' . $campoAlumno . '"required>';
        echo '</div>';
    }
}

?>

            
                <div class="form-group row">
                    <label >Seleccione foto alumno: </label>
                    <input type="file" name="foto" class="form-control-file col-10 col-sm-7 col-md-8 offset-1 offset-sm-0" id="exampleInputFile" aria-describedby="fileHelp" style="margin-top: 15px">
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
      
