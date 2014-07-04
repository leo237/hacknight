<?php
	include_once("lib/connection.php");

	$userID = $_REQUEST['id'];


	$sql = "SELECT interests.interest FROM interests, user WHERE interests.user_id = user.user_id AND user.user_ID = '$userID' ";

	$res= $mysqli->query($sql);
	
	$queryString = "";

	if ($res)
	{
		while ($data = $res->fetch_array())
		{
			$queryString = $queryString .(string)$data[0] . "+";
		}
	}
	else
		echo "FAIL";


	$queryString = substr($queryString,0,-1);
	//echo $queryString;

	$sql2 = "SELECT lat,lon FROM user WHERE user_ID = '$userID'";

	$res2 = $mysqli->query($sql2);

	if ($res2)
	{
		while ($data = $res2->fetch_array())
		{
			$latitude = $data[0];
			$longitude = $data[1];
			break;
		}
	}
	else
		echo "fail";


	$url = "http://api.meetup.com/2/open_events.json/?text=" .$queryString. "&lat=". $latitude . "&lon=".$longitude ."&key=346e4b63223dc27f7241112b61705";
	$json = file_get_contents($url);
	$data = json_decode($json, true);

	$i = 0;

	foreach ($data[results] as $details)
	{
		$card[$i][name] = $details[name];
		$card[$i][desc] = $details[description];
		$card[$i][url] = $details[event_url];
		$i++;
	}
	$interest = explode("+", $queryString);
	
	foreach ($interest as $int)
	{
		$url2 = "http://api.frrole.com/v1/curated-content?location=world&query=" . $int . "&apikey=hacknight-leo237-AfFmaAzclDx02JxylCbe53b7007e2b8c5";
		$json = file_get_contents($url2);
		$data = json_decode($json, true);
		$count = 0;
		foreach($data[results] as $details)
		{
				$card[$i][name] = $details[displayname];
				$card[$i][desc] = $details[tweet_text];
				if ($details[entities] != NULL)
					$card[$i][url]  = $details[entities][0][url];
				else
					$card[$i][url] = NULL;
				$i++;
				$count++;
				if ($count == 2)
					break;
		}
	}
	$finalJson = json_encode($card);
	echo $finalJson;
	
?>