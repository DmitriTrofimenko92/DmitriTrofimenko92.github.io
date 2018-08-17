<head>
  <title>Renamer - RUN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style type="text/css">

  li{
  margin: 5px;
  }
  #panel, #flip {
  		display: none;
      padding: 5px;
      text-align: center;
      background-color: #e5eecc;
      border: solid 1px #c3c3c3;
  }

  #panel {
      padding: 50px;
      display: none;
  }

</style>

<?php
error_reporting(0);
set_time_limit(200);
require('filesystem.php');
require('datacheck.class.php');





?>.
          <div class="container">

         <a href="renamer.php"><button type="submit" class="btn btn-info">Ir al renombrador</button></a>

<div id="flip">Click para ver las alertas.</div>
<div id="panel">
<?php
$cantidad = 0;
$errores = 0;
$alertas = 0;
$dir = $_SERVER['DOCUMENT_ROOT'].'/Renamer/imagenes/';
$newdir = $_SERVER['DOCUMENT_ROOT'].'/Renamer/renombradas/';
echo "<ul>";
    foreach ($_POST["file"] as $key => $value) {
      $filename = $dir.$key;
      $newfilename= $newdir.strtolower($value).".jpg";
      if (strpos(strtolower($value), 'sku')) {
        echo "<li class='bg-warning'>No se realizó ningun cambio sobre el '$key' (Sku no encontrado)</li>";
        $alertas++;
      } else if (strpos(strtolower($value), 'color')) {
        echo "<li class='bg-info'>No se realizó ningun cambio sobre el '$key' (Color no encontrado)</li>";
        $cantidad++;
      } else if (rename($filename, $newfilename)) {
        echo "<li class='bg-success'>Archivo '$key' fue renombrado a '$newfilename'</li>";
        $cantidad++;
      }else {
        echo "<li class='bg-danger'>Error en el '$key' </li> ";
        $errores++;
      }

    }
    echo "<li>Cantidad de imagenes renombradas: $cantidad </li>";
    echo "<li>Cantidad de errores: $errores </li>";
    echo "<li>Cantidad de alertas: $alertas </li>";
echo "</ul>";

?>






</div>
</div>
</div>
<br>
<hr>
<div class="row">
<?php


$renombradas = getFileNamesInside('renombradas');
$sinrenombrar = getFileNamesInside('imagenes');
?>
<div class="col-sm-4">
	<p>Subir imagenes sin renombrar + "data.csv" con las columnas sku - marca_color</p>

		<form enctype="multipart/form-data" action="" method="POST">
			<input class='btn btn-info' name="upload[]" type="file" multiple="multiple" /><input class='btn btn-success' type="submit" value="Subir Archivos Seleccionados"></input>

		</form>
		<form action="" method="POST">
			<button class='btn btn-danger' name="vaciarSinRenombrar" type="submit" value="">Vaciar</button>
		</form>
	<hr>
	<?php for ($i=0; $i < count($sinrenombrar) ; $i++) {
			echo $sinrenombrar[$i] . '<br>';
	} ?>
</div>

  <div class="col-sm-4">


    <p>Imagenes Renombradas</p>


		<a href="download.php"><button type="submit" class="btn btn-success">Descargar Imagenes Renombradas</button></a>
			<br>
		<form action="" method="POST">
			<button class='btn btn-danger' name="vaciarRenombradas" type="submit" value="">Vaciar</button>
		</form>

    <hr>
    <?php for ($i=0; $i < count($renombradas) ; $i++) {
        echo $renombradas[$i] . '<br>';
    } ?>
  </div>



  <div class="col-sm-4">
    sku<br>
    <?php
    $skus = [];
    for ($i=0; $i < count($renombradas) ; $i++) {
        $check = new datacheck($renombradas[$i],$csvArray);
        array_push($skus,$check->getSku());
    }

    for ($i=0; $i < count($skus); $i++) {
       if ($skus[$i] != '') {
      	echo $skus[$i] . '<br>';
      }
    }

    ?>
  </div>
</div>






<script>
$(document).ready(function(){
    $("#flip").click(function(){
        $("#panel").slideToggle("slow");
    });
});
</script>
