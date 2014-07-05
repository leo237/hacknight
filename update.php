<?php
include("lib/connection.php");

$email= $_REQUEST['email'];
$name= $_REQUEST['name'];
$intr= $_REQUEST['interest'];
$lon= $_REQUEST['lon'];
$lat= $_REQUEST['lat'];



echo $email;

$interest= explode(",", $intr);
$size= sizeof($interest);

$preSql = "SELECT email FROM user WHERE email = '$email' ";
$preRes = $mysqli->query($preSql);

if (($preRes->num_rows) == 0)
{
    //echo "Im here!";
    $sql_con= "INSERT INTO `user` SET 
      			`name`= '$name',
      			`email`= '$email',
      			`lon`= '$lon',
      			`lat`= '$lat'";

     $res= $mysqli->query($sql_con);
     //echo $res;

     if($res)
     {

     		  $sql_query= "SELECT * FROM `user` WHERE `email`='$email'";
      		$res= $mysqli->query($sql_query);
      		$data= $res->fetch_assoc();
      		$user_id= $data['user_id'];
      		$output['id']= $user_id;
      		$i= 0;
      		while($i<$size)
      		{
      			$inter= $interest[$i];
      			$sql_con= "INSERT INTO `interests` SET 
      					`interest`= '$inter',
      					`user_id`= '$user_id'";
      			$res1= $mysqli->query($sql_con);
      			$i++;
      		}
      		$output['msg']= "Success";
      		$output['id']= $user_id;

      		$outputJson= json_encode($output);
      		echo $outputJson;
      		
      }
  }
  else
  {
      $sql = "UPDATE user SET
            name = '$name',
            lon = '$lon',
            lat = '$lat' ";
      $res = $mysqli->query($sql);


      $sql_query= "SELECT user_id FROM user WHERE email='$email'";
      $res = $mysqli->query($sql_query);

      $data = $res->fetch_assoc();
      $id = $data['user_id'];
      $sql2 = "DELETE FROM interests WHERE user_id = '$id' ";
      $res2 = $mysqli->query($sql2);
      
      while($i<$size)
      {
        $inter= $interest[$i];
        $sql_con= "INSERT INTO `interests` SET 
            `interest`= '$inter',
            `user_id`= '$id'";
        $res1= $mysqli->query($sql_con);
        $i++;
      }

      $output['msg']= "Success";
      $output['id']= $id;

      $outputJson= json_encode($output);
      echo $outputJson;

  }
?>