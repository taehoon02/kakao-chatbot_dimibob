<?php
$data = json_decode(file_get_contents('php://input'), true);
$content = $data["content"];

$header = array(
  'Content-type: application/json',
);

$date = date("Ymd");
$date_show = date("m월 d일");
$url = 'https://api.dimigo.in/dimibobes/' . $date;

$tomorrow = date("Ymd", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
$tomorrow_show = date("m월 d일", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
$url2 = 'https://api.dimigo.in/dimibobes/' . $tomorrow;



// Open connection
$ch = curl_init();
// Set the url, number of GET vars, GET data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Execute request
$result = curl_exec($ch);
// Close connection
curl_close($ch);

$result_arr = json_decode($result, true);

$breakfast = $result_arr['breakfast'];
if ($breakfast == null) $breakfast_show = "급식 정보가 없습니다.";
else $breakfast_show = "오늘($date_show) 아침은 $breakfast 입니다.";

$lunch = $result_arr['lunch'];
if ($lunch == null) $lunch_show = "급식 정보가 없습니다.";
else $lunch_show = "오늘($date_show) 점심은 $lunch 입니다.";

$dinner = $result_arr['dinner'];
if ($dinner == null) $dinner_show = "급식 정보가 없습니다.";
else $dinner_show = "오늘($date_show) 저녁은 $dinner 입니다.";

$snack = $result_arr['snack'];
if ($snack == null) $snack_show = "간식 정보가 없습니다.";
else $snack_show = "오늘($date_show) 간식은 $snack 입니다.";



// Open connection
$ch2 = curl_init();
// Set the url, number of GET vars, GET data
curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_POST, false);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
// Execute request
$result = curl_exec($ch2);
// Close connection
curl_close($ch2);

$result_arr = json_decode($result, true);

$breakfast2 = $result_arr['breakfast'];
if ($breakfast2 == null) $breakfast2_show = "급식 정보가 없습니다.";
else $breakfast2_show = "내일($tomorrow_show) 아침은 $breakfast2 입니다.";

if ($content == "아침") {
echo <<< EOD
  {
    "message": {
        "text": "$breakfast_show"
    },
    "keyboard": {
        "type": "buttons",
        "buttons": ["아침", "점심", "저녁", "간식", "내일 아침"]
    }
  }
EOD;
}

else if ($content == "점심")  {
echo <<< EOD
  {
    "message": {
         "text": "$lunch_show"
    },
    "keyboard": {
        "type": "buttons",
        "buttons": ["아침", "점심", "저녁", "간식", "내일 아침"]
    }
  }
EOD;
}

else if ($content == "저녁") {
echo <<< EOD
  {
    "message": {
         "text": "$dinner_show"
    },
    "keyboard": {
        "type": "buttons",
        "buttons": ["아침", "점심", "저녁", "간식", "내일 아침"]
    }
  }
EOD;
}

else if ($content == "간식") {
echo <<< EOD
  {
    "message": {
         "text": "$snack_show"
    },
    "keyboard": {
        "type": "buttons",
        "buttons": ["아침", "점심", "저녁", "간식", "내일 아침"]
    }
  }
EOD;
}

else if ($content == "내일 아침") {
echo <<< EOD
  {
    "message": {
         "text": "$breakfast2_show"
    },
    "keyboard": {
        "type": "buttons",
        "buttons": ["아침", "점심", "저녁", "간식", "내일 아침"]
    }
  }
EOD;
}
?>
