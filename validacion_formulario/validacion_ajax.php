<?php
$errorNombre = $errorApellidos = $errorEmail = '';
      $errores = array(); //no hay errores
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
          
                 
        function saneado($valor){
          $nuevoValor = trim($valor);
          $nuevoValor = htmlspecialchars($nuevoValor);
          return ($nuevoValor);
        }
        
        if (empty($_POST['nombre'])) {
          $errores['nombre'] = 'El nombre es obligatorio.';
        } else {
            $nombre = saneado($_POST['nombre']);
        }
        if (empty($_POST['apellidos'])) {
          $errores['apellidos'] = 'Los apellidos son obligatorios.';
        } else {
            $apellidos = saneado($_POST['apellidos']);
        }
        if (empty($_POST['email'])) {
            $errores ['email'] = 'El email es obligatorio';
        } else {
            $email = saneado($_POST['email']);
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
              $errores = 'Formato de email no válido.';
            }
        } 
        if (empty($_POST['telefono'])) {
            $errores ['telefono'] = 'El teléfono es obligatorio';
        } else {
            $telefono = saneado($_POST['telefono']);
            $regexp = array('options'=> array('repexg' => '/^[0-9]{9}$/'));
            if (!filter_var($_POST['telefono'], FILTER_VALIDATE_REGEXP, $regexp)) {
              $errores['telefono'] = 'Formato de teléfono no válido.';
            }
        }
      
      //empezamos subida a BdD
      
       $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($errores == false){
          $sql = "INSERT INTO contacto
                  (nombre, apellidos, email, telefono)
                  VALUES
                  (?, ?, ?, ?)
                  ";
          try {
            $st = $db->prepare($sql);
            $st->execute(array($nombre, $apellidos, $email, $telefono));
          } catch(Exception $e) {
              echo $e->getMessage();
              return false;
          }
        } else {
            header('Content-Type: application/json');
            echo json_encode($errores);
        }
      }
      ?>