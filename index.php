<?php
ob_start();
$token = '5894044006:AAGvMpDjfFeImWrNCioME29pu3pZPFyhViA';
$admin = '1150081918';
define('API_KEY', $token);
function bot($method, $datas = [])
{
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$tx = $message->text;
$cid = $message->chat->id;
$uid = $message->from->id;
$ty = $message->chat->type;
$name = $message->from->first_name;
$mid = $message->message_id;
$audio = $message->audio;
$data = $update->callback_query->data;
$cmid = $update->callback_query->message->message_id;
$ccid = $update->callback_query->message->chat->id;
$cuid = $update->callback_query->message->from->id;
$qid = $update->callback_query->id; 
$ctext = $update->callback_query->message->text; 
$callfrid = $update->callback_query->from->id; 
$callfname = $update->callback_query->from->first_name;  
$calltitle = $update->callback_query->message->chat->title; 
$calluser = $update->callback_query->message->chat->username; 
$channel = $update->channel_post; //shu
$channel_text = $channel->text;
$channel_mid = $channel->message_id; 
$channel_id = $channel->chat->id; 
$channel_title = $channel->chat->title;
$channel_user = $channel->chat->username; 
$chanel_doc = $channel->document; 
$chanel_vid = $channel->video; 
$chanel_mus = $channel->audio; 
$chanel_voi = $channel->voice; 
$chanel_gif = $channel->animation; 
$chanel_fot = $channel->photo; //shu
$chanel_txt = $channel->text; 
$caption =$channel->caption; 
$chat_id = $message->chat->id;

mkdir("stat");
$guruhlar = file_get_contents("stat/channel.txt");
$userlar = file_get_contents("stat/users.txt");
$xabar = file_get_contents("xabarlar.txt");
     
if($tx == "/start") {
	   $userlar = file_get_contents("stat/users.txt");
   if(stripos($userlar,"$cid")!==false){
    }else{
    file_put_contents("stat/users.txt","$userlar\n$cid");
       }     
bot('sendMessage',[
'chat_id'=>$cid,
'parse_mode'=>"markdown",
'text'=>"*😁Bu bot @italianskiye_bass_muzik kanali uchun tayyorlangan bot
sizga ham kerak bosa @Alibek_0620 ga yozing!✅✅*",
]);
}

     if (isset($message->audio)){
     	if(stripos($guruhlar,"$channel_id")!==false){
    }else{
    file_put_contents("stat/channel.txt","$guruhlar\n$channel_id");
    }  
$file_id = $message->audio->file_id;
      $get = bot('getfile',['file_id'=>$file_id]);
      $patch = $get->result->file_path;
      file_put_contents('test.mp3', file_get_contents('https://api.telegram.org/file/bot'.API_KEY.'/'.$patch));
copy('https://api.telegram.org/file/bot'.API_KEY.'/'.$patch, 'music.mp3');
}
if (isset($channel->audio)){
	if(stripos($guruhlar,"$channel_id")!==false){
    }else{
    file_put_contents("stat/channel.txt","$guruhlar\n$channel_id");
    }  
$file_id = $channel->audio->file_id;
$title = $channel->audio->title;
$performer = $channel->audio->performer;
      $get = bot('getfile',['file_id'=>$file_id]);
      $patch = $get->result->file_path;
      file_put_contents('music.mp3', file_get_contents('https://api.telegram.org/file/bot'.API_KEY.'/'.$patch));
bot('deletemessage',[
    'chat_id'=>$channel_id,
    'message_id'=>$channel_mid,
  ]);
bot('sendaudio',[
'chat_id'=>$channel_id,
'audio'=>new CURLFile("music.mp3"),
'thumb'=>new CURLFile("image.jpg"),
'title'=>"$performer - $title",
'performer'=>'@'.$channel_user,
 'caption'=>"*$caption*\n* @italianskiye_bass_muzik *",
 'parse_mode'=>"markdown",
]);
} 

if($tx=="/send" and $cid==$admin){
  bot('sendmessage',[
    'chat_id'=>$admin,
    'text'=>"Yuboriladigan xabar matnini kiriting!",
    'parse_mode'=>"html",
]);
    file_put_contents("xabarlar.txt","user");
}
if($xabar=="user" and $cid==$admin){
if($tx=="/otmen"){
  file_put_contents("xabarlar.txt","");
}else{
  $lich = file_get_contents("stat/users.txt");
  $lichka = explode("\n",$lich);
  foreach($lichka as $lichkalar){
  $okuser=bot("sendmessage",[
    'chat_id'=>$lichkalar,
    'text'=>$tx,
    'parse_mode'=>'html'
]);
}

if($okuser){
  bot("sendmessage",[
    'chat_id'=>$admin,
    'text'=>"Hamma userlarga yuborildi!",
    'parse_mode'=>'html',
]);
  file_put_contents("xabarlar.txt","");
}
}
}
if($tx=="/sendchannel" and $cid==$admin){
  bot('sendmessage',[
    'chat_id'=>$admin,
    'text'=>"Kanallarga yuboriladigan xabar matnini kiriting!",
    'parse_mode'=>"html",
  ]);
  file_put_contents("xabarlar.txt","guruh");
}
if($xabar=="guruh" and $cid==$admin){
  if($tx=="/otmen"){
  file_put_contents("xabarlar.txt","");
}else{
  $gr = file_get_contents("stat/channel.txt");
  $grup = explode("\n",$gr);
foreach($grup as $chatlar){
  $okguruh=bot("sendmessage",[
    'chat_id'=>$chatlar,
    'text'=>$tx,
    'parse_mode'=>'html',
]);
}
if($okguruh){ 
  bot("sendmessage",[
    'chat_id'=>$admin,
    'text'=>"Hamma kanallarga yuborildi!",
    'parse_mode'=>'html',
]);
  file_put_contents("xabarlar.txt","");
}
}
} 
if($tx == "/stat"){
$gr = substr_count($guruhlar,"\n"); 
$us = substr_count($userlar,"\n"); 
$obsh = $gr + $us;
   bot('sendMessage',[
   'chat_id'=>$cid,
    'text'=> "Bot statistikasi:

A'zolar: <b>$us</b>

Kanallar: <b>$gr</b>

Umumiy: <b>$obsh</b>\n",
'parse_mode' => 'html',
]);
}

?>
