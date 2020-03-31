<?php
  $LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);

  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];

$nameRegis = substr($text,8);

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



//Check User
  $getUser = $mysql->query("SELECT * FROM `persontb` WHERE userID = '$userID'");
  $getuserNum = $getUser->num_rows;
  $replyText["type"] = "text";
  if ($getuserNum == "0"){
	  
	  $mysql->query("UPDATE `persontb` SET `userID`='$userID' WHERE `p_name` like '%$nameRegis%'");
	  
	  
	  $accessToken = "TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['userId'];
   #ตัวอย่าง Message Type "Text + Sticker"

      $arrayPostData['to'] = $userID;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "ลงทะเบียนในระบบให้เรียบร้อยแล้วครับ...";
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "1";
      $arrayPostData['messages'][1]['stickerId'] = "2";
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
   exit;
	  	 
	
  } else {  //Check User
    while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $position = $row['position'];
    }
	  
$accessToken = "TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['userId'];
   #ตัวอย่าง Message Type "Text + Sticker"

      $arrayPostData['to'] = $userID;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "คุณ $p_name ได้ลงทะเบียนในระบบไว้แล้วครับ...";
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
   exit;
    
  } //Check User


  
  
  http_response_code(200);

?>