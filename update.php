<?php
include("connection.php");

$email= $_REQUEST['email'];
$name= $_REQUEST['name'];
$intr= $_REQUEST['interest'];
$location= $_REQUEST['location'];

$interest= explode(",", $intr);
$size= sizeof($interest);

$sql_con= "INSERT INTO `user` SET 
  			`name`= '$name',
  			`email`= '$email',
  			`location`= '$location'";
 $res= $mysqli->query($sql_con);
 if($res)
 {
 		$sql_query= "SELECT `id` FROM `user` WHERE `email`='$email'";
  		$res= $mysqli->query($sql_query);
  		$data= $fetch_assoc($res);
  		$user_id= $data[`id`];
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
  			}
  		}
  		
 }
?>