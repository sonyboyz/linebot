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
	   	
	  
      $arrayPostData['to'] = $id;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "ลงทะเบียนให้เรียบร้อยแล้วครับ ^ ^";
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "2";
      $arrayPostData['messages'][1]['stickerId'] = "4";
      pushMsg($arrayHeader,$arrayPostData);
  
   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
	   $mysql->query("INSERT INTO `log`(`id_person`, `Text`, `Timestamp`, `detail`) VALUES ('$userID','$text','$timestamp','Check no Row')");
	  
	  exit;
  } else {
    while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $position = $row['position'];
    }
	  

	 
	  $arrayPostData['to'] = $id;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "คุณ $p_name ลงทะเบียนไปแล้วครับ ^ ^";
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "1";
      $arrayPostData['messages'][1]['stickerId'] = "4";
      pushMsg($arrayHeader,$arrayPostData);
  
   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
	  $mysql->query("INSERT INTO `log`(`id_person`, `Text`, `Timestamp`, `detail`) VALUES ('$userID','$text','$timestamp','Check Get Row')");
	  
	  exit;
	  //$replyText["text"] = "คุณ $p_name ลงทะเบียนไปแล้วครับ ^ ^";
   
  }

?>
