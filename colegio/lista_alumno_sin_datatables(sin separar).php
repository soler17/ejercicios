
<html>

<head>

<meta charset="utf-8">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
        #table{
            margin-top: 30px;
        }
        #table th{
            padding: 10px;
        }
        img{
            width: 80px;
        }
        thead a{
            color: white;
        }
        thead a:hover{
            color: white;
        }
        .pag{
            float: right;
            padding-top: 20px;
        }
        ul{
            list-style: none;
            float: right;
        }
        ul li{
           float: left;
        }
        ul li a{
            padding: 15px;
            color: black;
        }
        ul li a:hover{
            color: black;
            
        }
    </style>
    

</head>


<body>

    <div class="container">
        <h1 style="padding-top:30px">Base de datos de alumnos del instituto</h1>

        <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


        $db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries
        $sql = "SELECT COUNT(*) FROM alumno";
        
        try{
            $st = $db->prepare($sql);
            $st->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }

        setlocale(LC_TIME, 'es_ES.UTF-8');
        echo strftime("%A %d de %B del %Y");

        
        $numeroTotalAlumnos = $st->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
        $numeroFilasPagina = 2;
        $numeroPaginas = ceil($numeroTotalAlumnos / $numeroFilasPagina);
        
        
        $numeroPaginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $offset = ($numeroPaginaActual - 1) * $numeroFilasPagina;
        $columnaOrden = isset($_GET['columna_orden']) ? $_GET['columna_orden'] : 'id';
        $ordenLista= isset ($_GET['orden']) ? $_GET['orden'] : 'asc';
        
        $parametrosUrl = 'columna_orden=' . $columnaOrden;
        $parametrosUrl .= '&orden=' . $ordenLista;
        
        
        $sql = "SELECT * FROM alumno
            ORDER BY " .$columnaOrden. " " .$ordenLista.
            " LIMIT " .$numeroFilasPagina. " OFFSET " .$offset;
        
        try{
            $st = $db->prepare($sql);
            $st->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
        
        
        echo '<table id="table" class="thead-inverse" cellspacing="0" width="100%"  >';
        $primeraFila = $st->fetch(PDO::FETCH_ASSOC);
        $nombreColumnas = array_keys($primeraFila);
  

        echo '<thead>';
            echo '<tr>';
               
            foreach ($nombreColumnas as $nombreColumna) {
                if($nombreColumna == $columnaOrden){
                    
                    $ordenEnlace = $ordenLista == 'asc' ? 'desc' : 'asc';
                    
                } else {
                    $ordenEnlace = 'asc';
                }
                if ($nombreColumna == 'curso_id'){
                    echo '<th style="text-align:center"><a href="lista_alumno_sin_datatables.php?columna_orden='.$nombreColumna.'&orden='.$ordenEnlace.'">' . str_replace('curso_id', 'curso',   $nombreColumna). '</a></th>';
                } else{
                    echo '<th style="text-align:center; text-transform: capitalize"><a href="lista_alumno_sin_datatables.php?columna_orden='.$nombreColumna.'&orden='.$ordenEnlace.'">' . str_replace('_', ' ',   $nombreColumna). '</a></th>';
                }
            }
            echo '<th>Acciones</th>';
            echo '</tr>';
        echo '</thead>';

        echo '<tbody>';
            echo '<tr>';
            foreach ($primeraFila as $clave => $elementoPrimeraFila) {
                if ($clave == 'fecha_nacimiento') { 
                    echo '<td style="text-align:center">' . date("d-m-Y", strtotime($elementoPrimeraFila)) . '</td>';  
                } else if ($clave == 'nota_media') {
                    echo '<td style="text-align:right">' . 
                    $nota_media = number_format($elementoPrimeraFila, 2, ',', '.') . 
                    '</td>';
                } else if ($clave == 'foto_alumno') {
                    echo '<td style="text-align:center"> <img src = "uploads/' . $elementoPrimeraFila . '"> </td>';
                } else {    
                    echo '<td style="text-align:center">' . $elementoPrimeraFila . '</td>';
                }
            }
            echo '<td style="text-align:center"><a href="editar_alumno.php?id=' . $primeraFila['id'] . '"<i class="fa fa-pencil" aria-hidden="true">Editar</a>';
            echo '<br>';
            echo '<a  href="eliminar_alumno.php" class="eliminar fa fa-trash" aria-hidden="true">Eliminar</a></td>';
            echo '</tr>';

        while ($fila = $st->fetch(PDO::FETCH_ASSOC)){
          echo '<tr>';
            echo '<td style="text-align:center">' .$fila['id']. '</td>';
            echo '<td style="text-align:center">' .$fila['nombre_alumno']. '</td>';
            echo '<td style="text-align:center">' .$fila['apellidos_alumno']. '</td>';
            echo '<td style="text-align:center">' .date("d-m-Y", strtotime($fila['fecha_nacimiento'])). '</td>';
            echo '<td style="text-align:right">' .number_format($fila['nota_media'], 2, ',', '.'). '</td>';
            echo '<td style="text-align:center">' .$fila['curso_id']. '</td>';
            echo '<td style="text-align:center"><img src = "uploads/' .$fila['foto_alumno']. '"> </td>';
            echo '<td style="text-align:center"><a href="editar_alumno.php?id=' .$fila['id']. '"<i class="fa fa-pencil" aria-hidden="true"></i>Editar</a>';
            echo '<br>';
            echo '<a  href="eliminar_alumno.php" class="eliminar fa fa-trash" aria-hidden="true">Eliminar</a></td>';
          echo '</tr>';

        }
        echo '</tbody>';
        echo '</table>';
        ?>
        <div class="pag">Páginas:<ul>
        <?php
        for($i=0;$i<$numeroPaginas;$i++){
            $numeroPagina = $i+1;  
        
        ?> 
        
        <li><a href="lista_alumno_sin_datatables.php?<?php echo $parametrosUrl?>&pagina=<?php echo $numeroPagina ?>"><?php echo $numeroPagina ?></a></li>
        
        <?php
        }
        ?>
        </ul>
        </div>
        
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
