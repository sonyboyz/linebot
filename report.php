<?php
$LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);

  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];

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

 $getUser = $mysql->query("SELECT * FROM `persontb` WHERE `userID`='$userID'");
  $getuserNum = $getUser->num_rows;
      while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $id_person = $row['id_person'];
        $userID = $row['userID'];
      }
	  
	  $getLeave = $mysql->query("SELECT * FROM `leave_main` WHERE `id_person`='$id_person' and `years`='2563'");
  $getLeaveNum = $getLeave->num_rows;
      while($rowLeave = $getLeave->fetch_assoc()){
      $leave_sick = $rowLeave['leave_sick'];
      $leave_sick_use = $rowLeave['leave_sick_use'];
      $leave_vacation = $rowLeave['leave_vacation'];
      $leave_vacation_use = $rowLeave['leave_vacation_use'];
	  $leave_work = $rowLeave['leave_work'];
	  $leave_work_use = $rowLeave['leave_work_use'];
	  $leave_other = $rowLeave['leave_other'];
	  $leave_other_use = $rowLeave['leave_other_use'];
      }
	   if($title_name == 'นาย'){
	 $lOther = "อื่น ๆ";
 } else {
	  $lOther = "อื่น ๆ";
 }

	  $leave_sick_balance = $leave_sick - $leave_sick_use;
	  $leave_work_balance = $leave_work - $leave_work_use;
	  $leave_vacation_balance = $leave_vacation - $leave_vacation_use;
	  $leave_other_balance = $leave_other - $leave_other_use;

        
$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'b9294d4c452cc656fcd8e1d80086c11b';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$jsonFlex = [
  "type" => "flex",
  "altText" => "รายงานวันลา",
  "contents" => [
    "type" => "bubble",
    "direction" => "ltr",
    "header" => [
      "type" => "box",
      "layout" => "vertical",
      "contents" => [
        [
          "type" => "text",
          "text" => "ระบบรายงานวันลา",
          "margin" => "xs",
          "size" => "lg",
          "align" => "center",
          "gravity" => "bottom",
          "weight" => "bold",
          "color" => "#170574",
          "wrap" => true
        ],
        [
          "type" => "text",
          "text" => "$title_name$p_name",
          "size" => "lg",
          "align" => "center",
          "weight" => "bold",
          "color" => "#DD2104"
        ],
        [
          "type" => "separator",
          "color" => "#3A3030"
        ]
      ]
    ],
    "body" => [
      "type" => "box",
      "layout" => "vertical",
      "flex" => 2,
      "contents" => [
        [
          "type" => "box",
          "layout" => "baseline",
          "contents" => [
            [
              "type" => "text",
              "text" => "ลาพักผ่อน",
              "weight" => "bold",
              "color" => "#0D00B9"
            ],
            [
              "type" => "text",
              "text" => "ใช้ไป",
              "align" => "end",
			  "weight" => "bold"
            ]
			,
            [
              "type" => "text",
              "text" => "$leave_vacation_use  วัน",
              "align" => "end",
			  "weight" => "bold"
            ]
          ]
        ],
        [
          "type" => "box",
          "layout" => "baseline",
          "contents" => [
            [
              "type" => "text",
              "text" => "ลาป่วย",
              "color" => "#BB0D0D"
            ],
            [
              "type" => "text",
              "text" => "ใช้ไป",
              "align" => "end",
			  "weight" => "bold"             
            ]
			,
            [
              "type" => "text",
              "text" => "$leave_sick_use  วัน",
              "align" => "end",
			  "weight" => "bold"
            ]
          ]
        ],
        [
          "type" => "box",
          "layout" => "baseline",
          "contents" => [
            [
              "type" => "text",
              "text" => "ลากิจ",
              "color" => "#11AA08"
            ],
            [
              "type" => "text",
              "text" => "ใช้ไป",
              "align" => "end",
			  "weight" => "bold"             
            ]
			,
            [
              "type" => "text",
              "text" => "$leave_work_use  วัน",
              "align" => "end",
			  "weight" => "bold"
            ]
          ]
        ]
      ]
    ],
    "footer" => [
      "type" => "box",
      "layout" => "horizontal",
      "contents" => [
        [
          "type" => "button",
          "action" => [
            "type" => "uri",
            "label" => "ดูรายละเอียด",
            "uri" => "http://203.157.118.122/lcs/index.php?userID=$userID"
          ],
          "color" => "#4144E1",
          "style" => "primary"
        ],
		[
          "type" => "button",
          "action" => [
            "type" => "uri",
            "label" => "ยื่นใบลา",
            "uri" => "http://203.157.118.122/lcs/addlcs.php?userID=$userID"
          ],
          "color" => "#00BB51",
          "style" => "primary"
        ]
      ]
    ]
  ]
];



if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
        error_log(json_encode($event));
        $reply_message = '';
        $reply_token = $event['replyToken'];


        $data = [
            'to' => $userID,
            'messages' => [$jsonFlex]
        ];

        print_r($data);

        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/push', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
        
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

exit;

?>
