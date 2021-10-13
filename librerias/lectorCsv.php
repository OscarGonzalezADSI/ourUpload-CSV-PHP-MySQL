<?php

/*   
 *   fuentes:
 *   --------------------------------------------------------
 *   fgetcsv - www.php.net
 *   https://www.php.net/manual/en/function.fgetcsv.php
 **/

if (($handle = fopen("test.csv", "r")) !== FALSE) {
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
echo json_encode($json);

