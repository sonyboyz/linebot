<?php

  $LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);

  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];

//Register
$checkregis = substr($text,0,8);
if($checkregis == "register" ){
	include "register.php"; 
   }
//Register

//checkleave
if($text == "วันลา" ){
	include "report.php"; 
   }
//checkleave

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

  function sendMessage($replyJson, $sendInfo){
          $ch = curl_init($sendInfo["URL"]);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLINFO_HEADER_OUT, true);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Authorization: Bearer ' . $sendInfo["AccessToken"])
              );
          curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
          $result = curl_exec($ch);
          curl_close($ch);
    return $result;
  }


/*




//Check User
  $getUser = $mysql->query("SELECT * FROM `persontb` WHERE userID = '$userID'");
  $getuserNum = $getUser->num_rows;
  $replyText["type"] = "text";
  if ($getuserNum == "0"){
	  
	  //$mysql->query("UPDATE `persontb` SET `userID`='$userID' WHERE `phone`='$text'");
	    
    $replyText["text"] = "คุณยังไม่มีชื่ออยู่ในระบบครับ กรุณาพิมพ์ชื่อจริง โดยไม่ต้องพิมพ์นามสกุล ส่งมาให้ผมทีครับ ผมจะลงทะเบียนให้ครับ !!";
	 
	
  } else {
    while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $position = $row['position'];
    }
	  
  
	  $replyText["text"] = "กำลังตรวจสอบวันลาให้คุณ $p_name อยู่นะครับ รอรับข้อความได้เลยครับ ^ ^";

//Show Detail Flex MSG
    include "bot_push.php";
    
  }



//Reply MSG
  $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
  $lineData['AccessToken'] = "TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";

  $replyJson["replyToken"] = $replyToken;
  $replyJson["messages"][0] = $replyText;

  $encodeJson = json_encode($replyJson);

  $results = sendMessage($encodeJson,$lineData);
  echo $results;
  }
	  

  
*/  

//Log
$mysql->query("INSERT INTO `log`(`id_person`, `Text`, `Timestamp`) VALUES ('$userID','$text','$timestamp')");
	  


  http_response_code(200);



?>
