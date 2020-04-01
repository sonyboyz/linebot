<?php
$access_token="TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";
//เรียกใช้งานโดย
PushMessages("U250e4c274a06718a96420fdafdbb9706","พิมพ์ข้อมูลที่ต้องการ");
function PushMessages($userId,$text){
$access_token = $GLOBALS['access_token'];
$messages = array('type' => 'text','text' => $text);
// Make a POST Request to Messaging API to reply to sender
$url = 'https://api.line.me/v2/bot/message/push';
$data = array('to' => $userId,'messages' => array($messages));
$post = json_encode($data);
$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
return $result . "\r\n";
}
?>
