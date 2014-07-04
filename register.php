<?php
	include_once("lib/connection.php");
	
	$mail = $_REQUEST[email];

	$url = "https://vibeapp.co/api/v1/initial_data?api_key=acae5996e72c52835b0b15ed48208129&email=" . $mail . "&force=1" ;

	$url = str_replace('@', '%40', $url);
	//echo $url;

	$json = file_get_contents($url);
	$data = json_decode($json, true);

	$name = $data[name];

	$interestList = array();

	foreach ($data[topics] as $interest)
		$interestList[] = $interest;
	
	$finalList[name] = $name;
	$finalList[interests] = $interestList;

	$outputJson = json_encode($finalList);

	echo $outputJson;

	//echo $json;
?>