
<?php
/**
 * Genero un array con los nombres de archivo dentro del directorio
 */

 function getFileNamesInside($directorio)
 {
   $nombresdelasfotos = [];

   if ($handle = opendir($directorio)) {

       while (false !== ($entry = readdir($handle))) {

           if ($entry != "." && $entry != "..") {
             array_push($nombresdelasfotos,iconv("ISO-8859-1", "UTF-8", $entry));
           }
       }

       closedir($handle);
   }
   return  $nombresdelasfotos;
 }



 /*$total = count($_FILES['upload']['name']);

 // Loop through each file
 for($i=0; $i<$total; $i++) {
   //Get the temp file path
   $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

   //Make sure we have a filepath
   if ($tmpFilePath != ""){
     //Setup our new file path
     $newFilePath = "imagenes/" . $_FILES['upload']['name'][$i];

     //Upload the file into the temp dir
     if(move_uploaded_file($tmpFilePath, $newFilePath)) {

       //Handle other code here

     }
   }
 } */
  // GENERO UN ARRAY CON LA INFORMACION DEL CSV

 $csvArray = array_map('str_getcsv', file('imagenes/data.csv'));

function emptyDir($dir){
   $files = glob($dir); // get all file names
   foreach($files as $file){ // iterate files
     if(is_file($file))
       unlink($file); // delete file
   }
}




if (isset($_POST['vaciarRenombradas']))
            {
                emptyDir($_SERVER['DOCUMENT_ROOT'].'/Renamer/renombradas/*');
            }

if (isset($_POST['vaciarSinRenombrar']))
                {
                  emptyDir($_SERVER['DOCUMENT_ROOT'].'/Renamer/imagenes/*');

            }
