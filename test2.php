<?php
    $accessToken = "zREapw+JZ8kaDVAlz4Kq9gKVBpn646X8I1Gcq/0JO8zqegDtj24r3H81ceiviAkTSqGOdfERg3Ks4pBMw70S1BVbDqfDnKzXgt8hgQ0YoAWwumtNglT0tWQn/ID7kE8kJJRFlSwHeb2J+htYUCn+4gdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
#ตัวอย่าง Message Type "Text"
    if($message == "สวัสดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Image"
    else if($message == "รูปน้องแมว"){
      //  $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
	    $image_url = 'https://raw.githubusercontent.com/poeigame/pupoeibot/master/img/hs1.jpg';
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "image";
        $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
        $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Location"
    else if($message == "!bitec"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "location";
        $arrayPostData['messages'][0]['title'] = "bitec";
        $arrayPostData['messages'][0]['address'] =   "13.6724263,100.6104426";
        $arrayPostData['messages'][0]['latitude'] = "13.6724263";
        $arrayPostData['messages'][0]['longitude'] = "100.6104426";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
    else if($message == "ลาก่อน" || $message == "บาย"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ไปเถอะไปไกลๆ";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "7";
        replyMsg($arrayHeader,$arrayPostData);
    }
	else if(strpos($message,"มิวนิค") == true || $message == "มิวนิค"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "อย่าบด !";
        replyMsg($arrayHeader,$arrayPostData);
    }
	else if(strpos($message,"ปูเป้") == true || $message == "ปูเป้" || strpos($message,"ปู้ป") == true || $message == "ปู้ป"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "คนน่ารัก!";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "5";
		
        replyMsg($arrayHeader,$arrayPostData);
    }
	else if($message == "!hs" || $message == "!จับมือ")
	{
		  $hsimg1 = 'https://raw.githubusercontent.com/poeigame/pupoeibot/master/img/hs1.jpg';
		  $hsimg2 = 'https://raw.githubusercontent.com/poeigame/pupoeibot/master/img/hs2.jpg';
		  $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
		  $arrayPostData['messages'][0]['type'] = "image";
		  $arrayPostData['messages'][0]['originalContentUrl'] = $hsimg1;
          $arrayPostData['messages'][0]['previewImageUrl'] = $hsimg1;
		  $arrayPostData['messages'][1]['type'] = "image";
		  $arrayPostData['messages'][1]['originalContentUrl'] = $hsimg2;
          $arrayPostData['messages'][1]['previewImageUrl'] = $hsimg2;
          replyMsg($arrayHeader,$arrayPostData);
	}
function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
   exit;
?>