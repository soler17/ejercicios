
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Base de datos del Instituto</title>

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
        .formu{
            margin-top: 50px;
        }
        .color:active{
            color: blue;
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
        
        setlocale(LC_TIME, 'es_ES.UTF-8');
        echo strftime("%A %d de %B del %Y");
        
        $db = new PDO('mysql:host=mysql.hostinger.es;dbname=u133033580_cole;charset=utf8','u133033580_ubu','123456');//conexion a la BdD REMOTA
//$db = new PDO('mysql:host=localhost;dbname=colegio;charset=utf8','root','ubuntu');//conexion a traves de PDO para visualizar los errores de queries y conexion a la BdD LOCAL
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//nos muestra los errores de queries
        $sql = "SELECT COUNT(*) FROM alumno";
        
        try{
            $st = $db->prepare($sql);
            $st->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
        
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
        ?>
        
        <table id="table" class="thead-inverse" cellspacing="0" width="100%">
            
            <?php
            $primeraFila = $st->fetch(PDO::FETCH_ASSOC);
            $nombreColumnas = array_keys($primeraFila);
            ?>

            <thead>
                <tr>
                <?php foreach ($nombreColumnas as $nombreColumna) { ?>
                    <?php if($nombreColumna == $columnaOrden){ 
                        $ordenEnlace = $ordenLista == 'asc' ? 'desc' : 'asc' ?>
                    <?php } else {
                        $ordenEnlace = 'asc';
                    } ?>
                    <?php if ($nombreColumna == 'curso_id') { ?>
                        <th style="text-align:center; text-transform: capitalize">
                            <a href="lista_alumno_sin_datatables.php?columna_orden= 
                                <?php $nombreColumna ?> &orden= <?php $ordenEnlace ?> ">
                                <?php echo str_replace('curso_id', 'curso', $nombreColumna) ?>
                                <i href="eliminar_alumno.php?id=<?php echo $primeraFila['id'] ?>" class="fa fa-caret-up" aria-hidden="true"></i>
                                <i href="eliminar_alumno.php?id=<?php echo $primeraFila['id'] ?>"class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                       </th>
                    <?php } else { ?>
                        <th style="text-align:center; text-transform: capitalize">
                            <a href="lista_alumno_sin_datatables.php?columna_orden=
                                <?php $nombreColumna ?> &orden= <?php $ordenEnlace ?> ">
                                <?php echo str_replace('_', ' ', $nombreColumna) ?>
                                <a href="eliminar_alumno.php?id=<?php echo $primeraFila['id'] ?>"class="fa fa-caret-up" aria-hidden="true"></a>
                                <a href="eliminar_alumno.php?id=<?php echo $primeraFila['id'] ?>"class="fa fa-caret-down" aria-hidden="true"></a>
                            </a>
                        </th>
                    <?php } ?>
                <?php }?>
                        <th>Acciones</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
            <?php foreach ($primeraFila as $clave => $elementoPrimeraFila) {
                if ($clave == 'fecha_nacimiento') { ?>
                    <td style="text-align:center"> <?php echo date("d-m-Y", strtotime($elementoPrimeraFila)) ?> </td>  
                <?php } else if ($clave == 'nota_media') { ?>
                    <td style="text-align:center">
                        <?php echo $nota_media = number_format($elementoPrimeraFila, 2, ',', '.') ?>
                    </td>
                <?php } else if ($clave == 'foto_alumno') { ?>
                    <td style="text-align:center"> <img src = "uploads/<?php echo $elementoPrimeraFila ?> "></td>
                <?php } else { ?>    
                    <td style="text-align:center"> <?php echo $elementoPrimeraFila ?> </td>
                <?php }
            } ?>
                    <td style="text-align:center">
                        <a href="editar_alumno.php?id= 
                        <?php echo $primeraFila['id'] ?> "<i class="fa fa-pencil" aria-hidden="true">Editar
                        </a>
                        <br>
                        <a  href="eliminar_alumno.php?id=<?php echo $primeraFila['id'] ?>" class="eliminar fa fa-trash" aria-hidden="true">Eliminar
                        </a>
                    </td>
                </tr>

            <?php while ($fila = $st->fetch(PDO::FETCH_ASSOC)){ ?>
            <tr>
                <td style="text-align:center"> <?php echo $fila['id'] ?> </td>
                <td style="text-align:center"> <?php echo $fila['nombre_alumno'] ?> </td>
                <td style="text-align:center"> <?php echo $fila['apellidos_alumno'] ?> </td>
                <td style="text-align:center"> <?php echo date("d-m-Y", strtotime($fila['fecha_nacimiento'])) ?> </td>
                <td style="text-align:center"> <?php echo number_format($fila['nota_media'], 2, ',', '.') ?> </td>
                <td style="text-align:center"> <?php echo $fila['curso_id'] ?> </td>
                <td style="text-align:center">
                    <img src = "uploads/<?php echo $fila['foto_alumno'] ?>">
                </td>
                <td style="text-align:center">
                    <a href="editar_alumno.php?id= <?php echo $fila['id'] ?> "
                       <i class="fa fa-pencil" aria-hidden="true">
                        Editar
                    </a>
                <br>
                <a  href="eliminar_alumno.php?id=<?php echo $fila['id'] ?>" class="eliminar fa fa-trash" aria-hidden="true">Eliminar</a></td>
            </tr>

        <?php } ?>
            </tbody>
        </table>
 
        <div class="pag">Páginas:
            <ul>
                <?php
                for($i=0;$i<$numeroPaginas;$i++){
                    $numeroPagina = $i+1;  

                ?> 

                <li>
                    <a class="color" href="lista_alumno_sin_datatables.php?<?php echo $parametrosUrl?>&pagina=<?php echo $numeroPagina ?>"><?php echo $numeroPagina ?>
                    </a>
                </li>

                <?php
                }
                ?>
            </ul>
        </div>
        
        <button onclick="location.href='formulario_alumno.php'" type="button" class="btn btn-success formu" style="cursor: pointer">
             Ir a formulario</button>
    </div>

    <script>
        $('.eliminar').on('click', function(){
            return confirm('¿Esta seguro de que quiere borrar el alumno?');
        });
    </script>

</body>
</html>

