<?php
include("connection.php");

$email= $_REQUEST['email'];
$name= $_REQUEST['name'];
$intr= $_REQUEST['interest'];
$lon= $_REQUEST['lon'];
$lat= $_REQUEST['lat'];

$interest= explode(",", $intr);
$size= sizeof($interest);

$sql_con= "INSERT INTO `user` SET 
  			`name`= '$name',
  			`email`= '$email',
  			`lon`= '$lon',
  			`lat`= '$lat'";
 $res= $mysqli->query($sql_con);
 if($res)
 {
 		$sql_query= "SELECT `user_id` FROM `user` WHERE `email`='$email'";
  		$res= $mysqli->query($sql_query);
  		$data= $res->fetch_assoc();
  		$user_id= $data[`user_id`];
  		$i= 0;
  		while($i<$size)
  		{
  			$inter= $interest[$i];
  			$sql_con= "INSERT INTO `interests` SET 
  					`interest`= '$inter',
  					`user_id`= '$user_id'";
  			$res1= $mysqli->query($sql_con);
  			if($res1)
  			{
  				$output['msg']= "Success";
  				$output['id']= $user_id;

  				$outputJson= json_encode($output);
  				echo $outputJson;
  			}
  		}
  		
 }
?>