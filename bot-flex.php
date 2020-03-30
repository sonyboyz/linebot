<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'ouhqskdRP/sUP8uwpjAadPDJz6rj1Y3IR0/ZznmHBgsPmYq6Q+hzdEJ4OXgyw/8NaLy6GLAZYYbLhF/7S6i8K07k3yxT0sWcMEa6ixgJ2c0XIOEKRfUEQAsHVi4PbQU4HEk9GOq/cmdR3iRkQE9e5gdB04t89/1O/w1cDnyilFU='; 
$channelSecret = 'ba6e01c3eb0671a32e7d9fb3dbabd67d';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$jsonFlex = [
    "type" => "flex",
    "altText" => "Hello Flex Message",
    "contents" => [
      "type" => "bubble",
      "direction" => "ltr",
      "header" => [
        "type" => "box",
        "layout" => "vertical",
        "contents" => [
          [
            "type" => "text",
            "text" => "Purchase",
            "size" => "lg",
            "align" => "start",
            "weight" => "bold",
            "color" => "#009813"
          ],
          [
            "type" => "text",
            "text" => "฿ 100.00",
            "size" => "3xl",
            "weight" => "bold",
            "color" => "#000000"
          ],
          [
            "type" => "text",
            "text" => "Rabbit Line Pay",
            "size" => "lg",
            "weight" => "bold",
            "color" => "#000000"
          ],
          [
            "type" => "text",
            "text" => "2019.02.14 21:47 (GMT+0700)",
            "size" => "xs",
            "color" => "#B2B2B2"
          ],
          [
            "type" => "text",
            "text" => "Payment complete.",
            "margin" => "lg",
            "size" => "lg",
            "color" => "#000000"
          ]
        ]
      ],
      "body" => [
        "type" => "box",
        "layout" => "vertical",
        "contents" => [
          [
            "type" => "separator",
            "color" => "#C3C3C3"
          ],
          [
            "type" => "box",
            "layout" => "baseline",
            "margin" => "lg",
            "contents" => [
              [
                "type" => "text",
                "text" => "Merchant",
                "align" => "start",
                "color" => "#C3C3C3"
              ],
              [
                "type" => "text",
                "text" => "BTS 01",
                "align" => "end",
                "color" => "#000000"
              ]
            ]
          ],
          [
            "type" => "box",
[
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
          "text" => "นายวิวัฒน์ คล้ายหล่อ",
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
