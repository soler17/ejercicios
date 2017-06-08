<html>
  <head>
    <meta charset="utf-8">
    <title>Formulario de validación</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      .container{
        padding-top: 50px;
      }
      h1{
          padding-bottom: 20px;
      }
      label{
          font-weight: bold;
      }
      .asterisco{
        color: red;
        padding-left: 5px;
      }
      #enviar{
          font-weight: bold;
          cursor:pointer;
      }
      .fa{
          font-weight: bold;
      }
      .opcional{
          font-size: 12px;
          font-style: italic;
          font-weight: normal
      }
      .mensaje{
          color: red;
          font-style: italic;
          font-size: 14px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <?php
       ini_set('display_errors', 1);
       ini_set('display_startup_errors', 1);
       error_reporting(E_ALL);

              
      $errorNombre = $errorApellidos = $errorEmail = '';
      $errores = false; //no hay errores
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
          
                 
        function saneado($valor){
          $nuevoValor = trim($valor);
          $nuevoValor = htmlspecialchars($nuevoValor);
          return ($nuevoValor);
        }
        
        if (empty($_POST['nombre'])) {
          $errorNombre = 'El nombre es obligatorio.';
          $errores = true; //por lo tanto hay errores y no se sube a la BdD
        } else {
            $nombre = saneado($_POST['nombre']);
        }
        if (empty($_POST['apellidos'])) {
          $errorApellidos= 'Los apellidos son obligatorios.';
          $errores = true;
        } else {
            $apellidos = saneado($_POST['apellidos']);
        }
        if (empty($_POST['email'])) {
            $errorEmail = 'El email es obligatorio';
            $errores = true;
        } else {
            $email = saneado($_POST['email']);
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
              $errorEmail = 'Formato de email no válido.';
              $errores = true;
            }
        } 
          
      //empezamos subida a BdD
      
       $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($errores == false){
          $sql = "INSERT INTO contacto
                  (nombre, apellidos, email)
                  VALUES
                  (?, ?, ?)
                  ";
          try {
            $st = $db->prepare($sql);
            $st->execute(array($nombre, $apellidos, $email));
          } catch(Exception $e) {
              echo $e->getMessage();
              return false;
          }
        }
      }
      ?>
        <h1>Nuevo formulario</h1>  
      <form method="POST">
        <div class="form-group">
          <div class="form-group">
            <label class="col-md-2">Nombre:<span class="asterisco">*</span></label>
            <input type="text" name="nombre" class="col-md-4" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''?>">
            <span class="mensaje"><?php echo $errorNombre ?></span>
          </div>
          <div class="form-group">
            <label class="col-md-2">Apellidos:<span class="asterisco">*</span></label>
            <input type="text" name="apellidos" class="col-md-4" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : ''?>">
            <span class="mensaje"><?php echo $errorApellidos ?></span>
          </div>
          <div class="form-group">
            <label class="col-md-2">Email:<span class="asterisco">*</span></label>
            <input type="text" name="email" class="col-md-4" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''?>">
            <span class="mensaje"><?php echo $errorEmail ?></span>
          </div>
            <div class="form-group">
            <label class="col-md-2">Sitio web<span class="opcional">(opcional):</span></label>
            <input type="text" name="web" class="col-md-4" value="<?php echo isset($_POST['web']) ? $_POST['web'] : ''?>">
          </div>  
          <button type="submit" id="enviar" value="Enviar formulario" class="btn btn-primary">Enviar &nbsp;
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
          </button>
        </div>
      </form>
    </div>
      
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"  crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"  crossorigin="anonymous"></script>
  </body>
    
</html>