<html>

<head>

<meta charset="utf-8">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
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
 dateFormat: 'yy-mm-dd',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
$("#calendario").datepicker();
 
});
</script>

</head>


<body>


<header>
 <div class="container" style="padding-top: 20px">
   <h3>Ingresar nuevo alumno:</h3>
 </div>
</header>


<main>
  <div class="container" style="padding-top: 20px">
  <form action="nuevo_alumno.php" method="post" enctype="multipart/form-data">
    <div class="form-group row">
      <label class="col-sm-4 col-md-3 col-form-label offset-md-1 offset-1">Nombre alumno:</label>
      <div class="col-10 col-sm-9 col-md-7 col-lg-6 offset-1 offset-md-0">
        <input type="text" class="form-control" name="nombre_alumno">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4 col-md-3 col-form-label offset-md-1 offset-1">Apellidos alumno:</label>
      <div class="col-10 col-sm-9 col-md-7 col-lg-6 offset-1 offset-md-0">
        <input type="text" class="form-control" name="apellidos_alumno">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-4  col-md-3 col-form-label offset-md-1 offset-1">Fecha de nacimiento: </label>
      <div class="col-10 col-sm-9 col-md-7 col-lg-6 offset-1 offset-md-0">
        <input type="date" class="form-control" id="calendario" name="fecha_nacimiento" style="cursor:pointer">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-2 col-sm-2 col-form-label offset-md-1 offset-1">Curso: </label>
<?php

$conn = new mysqli('localhost','root','ubuntu', "colegio"); 

$sql = "SELECT * FROM curso";
$result = $conn->query($sql);

      echo '<div class="col-10 col-sm-4 col-md-3 col-lg-2 offset-sm-0 offset-md-1 offset-1">';
      echo ' <select class="custom-select " name="curso_id" style="cursor:pointer">';

      echo '<option>Seleccione curso</option>';
      while ($fila = $result->fetch_assoc()){

 echo '<option value="' . $fila['id'] .'"> ' . $fila['nombre'] . '</option>';	  
}
          
	  
     echo '</select>'; 
   echo '</div>';
$conn->query($sql);

?>
    </div>
    <div class="form-group row">
      <label class="col-10 col-sm-4 col-md-3 col-form-label offset-1">Seleccione foto alumno: </label>
      <input type="file" name="archivo" class="form-control-file col-10 col-sm-7 col-md-8 offset-1 offset-sm-0" id="exampleInputFile" aria-describedby="fileHelp" style="margin-top: 15px">
    </div>
    <div class="form-group"> 
      <input type="submit" class="btn btn-info offset-md-1 offset-1" value="Enviar nuevo alumno" style="cursor:pointer">
    </div>
  </form>

<button onclick="location.href='lista_alumno.php'" type="button" class="btn btn-success offset-md-1 offset-1" style="cursor: pointer">
     Ir a lista de alumnos</button>
</div>
</main>


</body>

</html>
