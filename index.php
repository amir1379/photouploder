<?php
define('API_KEY','YOURBOTTOKEN');

function bot($method,$datas=[]){
    $url = "https://api.pwrtelegram.xyz/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function is_url($uri){
    if(preg_match( '/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-zآ-ی]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$uri)){
        return $uri;
    }
    else{
        return false;
    }
}
function is_valid_url_international($url){
    return is_url($url);
}
$up = json_decode(file_get_contents('php://input'),true);
$msg = $up['message'];
$chat_id = $msg['from']['id'];
$type = $msg['entities'][0]['type'];
$text = $msg['text'];
if(isset($msg)){
  if(is_valid_url_international($text)){
    if(preg_match('/^(.*)(.png|.jpg|.jpeg)/',$text,$match)){
      $file = file_get_contents($text);
      if($file == true){
        echo 'ok';
        file_put_contents('image.png',$file);
        bot('sendphoto',array('chat_id'=>$chat_id,'photo'=>new CURLFile('image.png'),'caption'=>"\n\n@Amir_Dev"));
        bot('sendDocument',array('chat_id'=>$chat_id,'document'=>new CURLFile('image.png'),'caption'=>"\n\n@Amir_Dev"));
      }else{
        bot('SendMessage',array('chat_id'=>$chat_id,'text'=>"این لینک داری عکس نمی باشد"));
      }
    }
  }else{
    bot('SendMessage',array('chat_id'=>$chat_id,'text'=>"‼️ ربات تشخیص داده که لینکت اشتباهه !

      حدس میزنم https:// یا http:// اولش نذاشتی 😜"));
  }
}