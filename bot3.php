<?php
  $LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);

  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];

//test Push MSG
if($text == "ขวัญ"){
      $arrayPostData['to'] = "U250e4c274a06718a96420fdafdbb9706";
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา คุณขวัญ";
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "2";
      $arrayPostData['messages'][1]['stickerId'] = "34";
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
   } else if($text == "ขวัญ2"){
      $arrayPostData['to'] = "U40de59c6aace1e1efd5d04a18ac84e5f";
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา ขวัญญญญ 2";
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "2";
      $arrayPostData['messages'][1]['stickerId'] = "34";
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
   }
   
//Test Push MSG

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

$mysql->query("INSERT INTO `log`(`id_person`, `Text`, `Timestamp`) VALUES ('$userID','$text','$timestamp')");

  $getUser = $mysql->query("SELECT * FROM `persontb` WHERE `phone`='$text'");
  $getuserNum = $getUser->num_rows;
  $replyText["type"] = "text";
  if ($getuserNum == "0"){
	  $mysql->query("UPDATE `userLine` SET `phone`='$userID' WHERE `phone`='$text'");
	    
    $replyText["text"] = "ยังไม่มีชื่ออยู่ในระบบครับ กำลังบันทึกชื่อในระบบให้อยู่ครับ !!";
	
  } else {
    while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $idcard = $row['idcard'];
    }
    $replyText["text"] = "สวัสดีคุณ $p_name ($idcard)";
    include "bot5.php";
    //header( "location: bot5.php?cid=$CustomerID" );
    //print "<META HTTP-EQUIV=Refresh CONTENT=0 URL=bot5.php?cid=$CustomerID>";
       
    
  }

  $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
  $lineData['AccessToken'] = "TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";

  $replyJson["replyToken"] = $replyToken;
  $replyJson["messages"][0] = $replyText;

  $encodeJson = json_encode($replyJson);

  $results = sendMessage($encodeJson,$lineData);
  echo $results;
  http_response_code(200);



?>
