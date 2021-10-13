<?php
/* 
 * fuentes:
 * json_decode - php.net
 * https://www.php.net/manual/es/function.json-decode.php
 * https://www.php.net/manual/es/function.array-filter.php
 **/

include_once "../model/ModelUsers.php";


$target_dir = "../filesZip/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
/*
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
*/
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}
if ($_FILES["fileToUpload"]["size"] > 10000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "zip") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

$zip = new ZipArchive;
if ($zip->open('../filesZip/test.zip') === TRUE) {
    $zip->extractTo('../filesCsv/');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}

if (($handle = fopen("../filesCsv/test.csv", "r")) !== FALSE) {
	$myRow = 0;
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if ($myRow == 0){
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$campo[$c] = $data[$c];
			}			
		}else{
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$myData[$campo[$c]] = $data[$c];
			}
			$json[$myRow-1] = array_filter($myData);
		}
		$myRow++;
    }
    fclose($handle);
}

$json = json_encode($json);

try {
	$data = json_decode($json, true);
    $users = new ModelUsers();
	for($i=0; $i< count($data); $i++){
		$users->insertUser($data[$i]);
	}
	$users->closeconnection();
} catch(PDOException $e) {
	return "Error: " . $e->getMessage();
}

