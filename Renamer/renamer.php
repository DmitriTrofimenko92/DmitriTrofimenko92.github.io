<style type="text/css">

	img {
		max-width: 50px;
		height: auto;
	}

	img:hover {
		transform: scale(7, 7);
		transition-duration: 0.4s;
	}


</style>

<head>
	<title>Renamer - LIST</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">


	<br />
	<a href="index.php"><button type="submit" class="btn btn-info" class="btn btn-info" >Volver</button></a>

	<form action="index.php" method="post">
    <button id="rename" type="submit" class="btn btn-success" style='float:right'>Renombrar</button>
		<br />
		<br />
		<hr>
<?php
error_reporting(0);
set_time_limit(200);
require ('filesystem.php');

require ('datacheck.class.php');

$arrayImagenesARenombrar = getFileNamesInside("imagenes");
$arraydetodalainfo = [];

// print_r($arrayImagenesARenombrar);
// print_r($csvArray);
$arrayImagenesARenombrarLEN = count($arrayImagenesARenombrar);
for ($imagen = 0; $imagen < $arrayImagenesARenombrarLEN; $imagen++) {
	$foto = new datacheck($arrayImagenesARenombrar[$imagen], $csvArray);
	$imageURL = urlencode($arrayImagenesARenombrar[$imagen]);
	$arraydetodalainfo[$imagen]['filename'] = $arrayImagenesARenombrar[$imagen];
	$arraydetodalainfo[$imagen]['sku'] = $foto->getSku();
	$arraydetodalainfo[$imagen]['coloresSKU'] = $foto->getColoresSku();
	$arraydetodalainfo[$imagen]['color'] = $foto->getColor();
	$arraydetodalainfo[$imagen]['perfil'] = $foto->getPerfil();
	$arraydetodalainfo[$imagen]['brand'] = $foto->getBrand();
	$arraydetodalainfo[$imagen]['skucolor'] = $foto->getSku() . $foto->getColor();

	// echo $imagen . " => " . $arrayImagenesARenombrar[$imagen] . " => " . $foto->getSku()  . " => ". $foto->getColoresSku() . " => ". $foto->getColor() ." <br />";

}

// print_r($arraydetodalainfo);
// arsort($arraydetodalainfo,SORT_STRING);

function sortArray($data, $field)
{
	$field = (array)$field;
	usort($data,
	function ($a, $b) use($field)
	{
		$retval = 0;
		foreach($field as $fieldname) {
			if ($retval == 0) $retval = strnatcmp($a[$fieldname], $b[$fieldname]);
		}

		return $retval;
	});
	return $data;
}

$arrayOrdenado = sortArray($arraydetodalainfo, array(
	'sku',
	'color',
	'filename'
));

echo "<script> var cosas =JSON.parse('" . json_encode($arrayOrdenado) . "') </script>";
echo "<table class='table table-hover table-bordered'>";
echo "<tr>";
echo "<th> FILENAME </th>";
echo "<th> SKU ENCONTRADO </th>";
echo "<th> COLORES DEL SKU</th>";
echo "<th> COLOR ENCONTRADO </th>";
echo "<th> IMAGEN </th>";
echo "<th> NEW FILENAME </th>";
echo "</tr>";
$arrayOrdenadoLEN = count($arrayOrdenado);
for ($o = 0; $o < $arrayOrdenadoLEN; $o++) {
	$filename = $arrayOrdenado[$o]['filename'];
	$perfil = 1;
	$sku = $arrayOrdenado[$o]['sku'];
	$color = $arrayOrdenado[$o]['color'];
	if ($arrayOrdenado[$o]['skucolor'] != $arrayOrdenado[$o - 1]['skucolor']) {
		$arrayOrdenado[$o]['perfil'] = 1;
	}
	else {
		$arrayOrdenado[$o]['perfil'] = $arrayOrdenado[$o - 1]['perfil'] + 1;
	}

	$newfilename = $arrayOrdenado[$o]['brand'] . '_' . $arrayOrdenado[$o]['sku'] . '_' . $arrayOrdenado[$o]['color'] . '_' . $arrayOrdenado[$o]['perfil'];
	$newfilename = (strpos($sku, 'Not Found') ? '' : $newfilename);;
	echo "<tr id='$filename'>";
	echo "<td class=''> <span class='glyphicon glyphicon-picture'></span> " . $arrayOrdenado[$o]['filename'] . "</td>";
	echo "<td class=''>" . $arrayOrdenado[$o]['sku'] . "</td>";
	echo "<td class=''>" . $arrayOrdenado[$o]['coloresSKU'] . "</td>";
	echo "<td class=''>" . $arrayOrdenado[$o]['color'] . "</td>";
	echo "<td class=''> <img src='/Renamer/imagenes/" . $filename . "'></td>";
	echo "<td class='' id ='newfilename' style='width:300px'> <input type='text' class='form-control' name='file[$filename]' value='$newfilename'> </td>";
	echo "</tr>";
}

echo '</div>';
?>
	</form>
</body>






















<script type="text/javascript">
function resizeInput() {
	$(this).attr('size', $(this).val().length);
}

$('input[type="text"]')

	// event handler

	.keyup(resizeInput)

	// resize on page load

	.each(resizeInput);
</script>






<script>
	var newfilename = document.querySelectorAll("input");

	setInterval(function() {
		var error = 0;
		var arrayfilenames = ["test"];
		for (var i = 0; i < newfilename.length; i++) {

			if (arrayfilenames.indexOf(newfilename[i].value) >= 0) {
				newfilename[i].parentElement.parentElement.setAttribute("class", "warning");
				error++;
			} else if (newfilename[i].value.indexOf('SKU') > 0) {
				newfilename[i].parentElement.parentElement.setAttribute("class", "danger");

			} else if (newfilename[i].value.indexOf('COLOR') > 0) {
				newfilename[i].parentElement.parentElement.setAttribute("class", "danger");

			} else {


				arrayfilenames.push(newfilename[i].value);
				newfilename[i].parentElement.parentElement.setAttribute("class", "success");

			}

		}
		if (error != 0) {
			document.getElementById('rename').setAttribute("class", "btn btn-default disabled")
			document.getElementById('rename').innerHTML = "Hay valores duplicados";
			document.getElementById("rename").disabled = true;


		} else {
			document.getElementById('rename').setAttribute("class", "btn btn-info ")
			document.getElementById('rename').innerHTML = "Renombrar";
			document.getElementById("rename").disabled = false;

		}

	}, 1000);






</script>
