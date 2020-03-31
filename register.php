<?php
   $accessToken = "TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับข้อความจากผู้ใช้
   $message = $arrayJson['events'][0]['message']['text'];
   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['userId'];
   #ตัวอย่าง Message Type "Text + Sticker"
$nameRegis = substr($message,8);

//Check DB
  $servername = "203.157.118.122:3306";
  $username = "root";
  $password = "P-Triple1331";
  $dbname = "profile_rh2";
  $mysql = new mysqli($servername, $username, $password, $dbname);
  mysqli_set_charset($mysql, "utf8");

  if ($mysql->connect_error){
  $errorcode = $mysql->connect_error;
  print("MySQL(Connection)> ".$errorcode);
  }

 //Check User
  $getUser = $mysql->query("SELECT * FROM `persontb` WHERE userID = '$id'");
  $getuserNum = $getUser->num_rows;
  if ($getuserNum == "0"){
	  
	  //$mysql->query("UPDATE `persontb` SET `userID`='$userID' WHERE `phone`='$text'");
	   	
	   $mysql->query("INSERT INTO `log`(`id_person`, `Text`, `Timestamp`, `detail`) VALUES ('$userID','$text','$timestamp','Check no Row')");
	  include "noti_register.php"; 
	  exit;
  } else {
    while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $position = $row['position'];
    }
	  

	  $mysql->query("INSERT INTO `log`(`id_person`, `Text`, `Timestamp`, `detail`) VALUES ('$userID','$text','$timestamp','Check Get Row')");
	  include "noti_registed.php"; 
	  exit;
	  //$replyText["text"] = "คุณ $p_name ลงทะเบียนไปแล้วครับ ^ ^";
   
  }

?>
