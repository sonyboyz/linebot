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

 $getUser = $mysql->query("SELECT * FROM `persontb` WHERE `idcard`='$userID'");
  $getuserNum = $getUser->num_rows;
      while($row = $getUser->fetch_assoc()){
      $title_name = $row['title_name'];
      $p_name = $row['p_name'];
      $idcard = $row['idcard'];
      }

        
$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'b9294d4c452cc656fcd8e1d80086c11b';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$jsonFlex = [
  "type" => "flex",
  "altText" => "Flex Message",
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
              "text" => "ลาป่วย",
              "weight" => "regular",
              "color" => "#0D00B9"
            ],
            [
              "type" => "text",
              "text" => "คงเหลือ  15  วัน",
              "align" => "end",
              "color" => "#000000"
            ]
          ]
        ],
        [
          "type" => "box",
          "layout" => "baseline",
          "contents" => [
            [
              "type" => "text",
              "text" => "ลาพักผ่อน",
              "color" => "#BB0D0D"
            ],
            [
              "type" => "text",
              "text" => "คงเหลือ 12 วัน",
              "align" => "end"
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
              "text" => "คงเหลือ 5 วัน",
              "align" => "end"
            ]
          ]
        ],
        [
          "type" => "box",
          "layout" => "baseline",
          "contents" => [
            [
              "type" => "text",
              "text" => "ลาคลอด/อุปสมบท",
              "color" => "#1F262C"
            ],
            [
              "type" => "text",
              "text" => "คงเหลือ 20 วัน",
              "align" => "end"
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
            "label" => "ยื่นใบลา",
            "uri" => "http://www.rh2.go.th"
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
            'replyToken' => $reply_token,
            'messages' => [$jsonFlex]
        ];

        print_r($data);

        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

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

?>
