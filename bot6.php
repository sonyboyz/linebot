<?php
$access_token="TJIV2HgTqUm5oOrmeJQ9mnczGRvIQNVNTJu+VcqJzZcu3m0IyxOvuS7XhCZ3GzqHRcMapLuJnOdLjg0NQE5vgoEXZCNh4aaDN7okrye2ekQnzegrHbAcy/cHPpIIjA21Q0Maw7IvvvUtLFK2EuqobgdB04t89/1O/w1cDnyilFU=";


$LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);

  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];

//Flex
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


        print_r($jsonFlex);

        $post_body = json_encode($jsonFlex, JSON_UNESCAPED_UNICODE);


//Flex


//เรียกใช้งานโดย
PushMessages($userID,$post_body);
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
