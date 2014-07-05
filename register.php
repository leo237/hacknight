<?php
	include_once("lib/connection.php");
	
	$mail = $_REQUEST[email];

	$url = "https://vibeapp.co/api/v1/initial_data?api_key=acae5996e72c52835b0b15ed48208129&email=" . $mail . "&force=1" ;

	$url = str_replace('@', '%40', $url);
	//echo $url;

	$json = file_get_contents($url);
	$data = json_decode($json, true);
	
	echo $data[success];
	
	if ($data[success])
	{	
		$name = $data[name];

		$interestList = array();

		foreach ($data[topics] as $interest)
			$interestList[] = $interest;
		if ($data[profile_picture])	
			$profilePicture = $data[profile_picture];
		else
			$profilePicture = NULL;
		$finalList[name] = $name;
		$finalList[interests] = $interestList;
		$finalList[picture] = $profilePicture;

		$outputJson = json_encode($finalList);

		echo $outputJson;
	}
	else
	{
		echo "FAILURE";
	}

	//echo $json;
?>