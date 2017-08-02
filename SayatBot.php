<?php 

ob_start();

$API_KEY = '342863228:AAGa6E1mqJK_eif3-7bckQ7w1_u_dTws7mk';
define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
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

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$id = $update->callback_query->from->id;
$get = file_get_contents('pass.txt');
$ex_get = explode("\n", $get);

bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'results' => json_encode([[
            'type'=>'article',
            'id'=>base64_encode(rand(5,555)),
            'title'=>'شارك البوت',
            'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"اهلا بك عزيزي 🚹 في بوت ال Sayat ❄" . "\nيمكنك الحصول على رابط خاصك بك ♻️\nوارساله 💎 الى مستخدمي تليجرام 👥\nوتلقي الرسائل عبره بهوية غير معروفة ‼️"],
            'reply_markup'=>['inline_keyboard'=>[
                [
                ['text'=>'للدخول الى البوت 🤖❄️','url'=>"https://telegram.me/sayat_Ibot"] 
                 ],
                [
                 ['text'=>"تابعنا 📢", "url"=>"https://telegram.me/set_web"]
                 ]
             ]]
        ]])
        ]);


if($text == "id"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"الايدي الخاص بك : " . $from_id,
'reply_to_message_id'=>$message->message_id
]);
}


if($text == "/start"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'اهلا بك عزيزي 🚹 في بوت Sayat 💭' . "\n" . "احصل على رابطك الخاص ♻️ وبعدها قم بٲرساله 📫 الى مستخدمي تليجرام 👥 وسوف تتلقى رسائلهم بهوية مجهولة 🔕 البوت مماثل 🖱 للموقع الشهير sayat.me 💯",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'انشٲ رابطك ♻️', 'callback_data'=>"setlink"]
        ],
        [
        ['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
        ],
        [
        ['text'=>'المطور 🕴', 'url'=>"https://telegram.me/omar_real"]
        ],
        [
         ['text'=>'تابع جديدنا 📢', 'url'=>"https://telegram.me/set_web"]
        ],
        ]
])
]);
}



elseif($text == "/getlink" and !file_exists("tg/$from_id.txt")){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"الرابط الخاص بك 🚹🔻\n\nhttps://telegram.me/Sayat_IBot?start=$from_id"
]);
}

elseif($text == "/getlink" and file_exists("tg/$from_id.txt") and in_array($from_id, $ex_get)){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"لقد دخلت مسبقا ✅ الى رابط احد المستخدمين 👥 الرجاء قوم بل خروج 📛 من الرابط السابق وادخل مرة اخرى 🔷💡",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'خروج ➖🎴','callback_data'=>"out"]
],
[
['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
],
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>"home"]
]
]
])
]);
}

elseif($data == "setlink" and !file_exists("tg/$from_id.txt")){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"الرابط الخاص بك 🚹🔻\n\nhttps://telegram.me/Sayat_IBot?start=$id"
]);
}elseif($data == "setlink" and !file_exists("tg/$from_id.txt") and in_array($chat_id2, $ex_get)){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"لقد دخلت مسبقا ✅ الى رابط احد المستخدمين 👥 الرجاء قوم بل خروج 📛 من الرابط السابق وادخل مرة اخرى 🔷💡",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'خروج ➖🎴','callback_data'=>"out"]
],
[
['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
],
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>"home"]
]
]
])
]);
}


$link = explode(' ',$text);

if($text and in_array($link[1], $link) and !file_exists("tg/$from_id.txt") && $link[1] != $from_id){
file_put_contents("tg/$from_id.txt", $from_id . "\n" . $link[1]);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"لقد قمت بل للدخول ✨ الى رابط ال Sayat 💭\nكل ما ترسله الان 📧  سيذهب الى صاحب الرابط 🚹\nلا تقلق❗️لم يتم الكشف عن هويتك ❔",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'خروج ➖🎴','callback_data'=>"out"]
],
[
['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
],
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>"home"]
]
]
])
]);
}

elseif($text and in_array($link[1], $link) and $link[0] == "/start" and file_exists("tg/$from_id.txt") and $link[1] != $from_id){
unlink("tg/$chat_id.txt");
file_put_contents("tg/$from_id.txt", $from_id . "\n" . $link[1]);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"لقد قمت بل للدخول ✨ الى رابط ال Sayat 💭\nكل ما ترسله الان 📧  سيذهب الى صاحب الرابط 🚹\nلا تقلق❗️لم يتم الكشف عن هويتك ❔",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'خروج ➖🎴','callback_data'=>"out"]
],
[
['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
],
]
])
]);
}

elseif($text and in_array($link[1], $link) and !file_exists("tg/$from_id.txt") && $link[1] == $from_id){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"عذرا ‼️ لا يمكنك الدخول الى رابطك الخاص ✨\nارسل 📫 رابطك الى مستخدمي تليجرام 👥\nلتتلقى الرسائل بهوية مجهولة 📩🔒"
]);
}

if($text == "/out" and file_exists("tg/$from_id.txt")){
unlink("tg/$from_id.txt");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"لقد قمت بل خروج ‼️ من الرابط ♻️",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'انشٲ رابطك الخاص 💭','callback_data'=>"setlink"]
],
[
['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
],
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>"home"]
]
]
])
]);
}

if($text and file_exists("tg/$from_id.txt") and $link[0] != "/start"){
$send = file_get_contents("tg/$from_id.txt");
$ex_send = explode("\n",$send);

bot('sendMessage',[
'chat_id'=>$ex_send[1],
'text'=>$text
]);

bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"تم ✅ ارسال رسالتك 📩 بهوية مجهولة 👤🔒",
'reply_to_message_id'=>$message->message_id,
]);
}


if($data == "out" and file_exists("tg/$id.txt")){
unlink("tg/$id.txt");
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"لقد قمت بل خروج ‼️ من الرابط ♻️",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'انشٲ رابطك الخاص 💭','callback_data'=>"setlink"]
],
[
['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
],
[
['text'=>'الصفحة الرئيسية 🏠','callback_data'=>"home"]
]
]
])
]);
}

if($data == "home"){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'اهلا بك عزيزي 🚹 في بوت Sayat 💭' . "\n" . "احصل على رابطك الخاص ♻️ وبعدها قم بٲرساله 📫 الى مستخدمي تليجرام 👥 وسوف تتلقى رسائلهم بهوية مجهولة 🔕 البوت مماثل 🖱 للموقع الشهير sayat.me 💯",
'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [
          ['text'=>'انشٲ رابطك ♻️', 'callback_data'=>"setlink"]
        ],
[
        ['text'=>'اربح المال 💸', 'url'=>"http://babblecase.com/1a15"]
        ],
        [
        ['text'=>'المطور 🕴', 'url'=>"https://telegram.me/omar_real"]
        ],
        [
         ['text'=>'تابع جديدنا 📢', 'url'=>"https://telegram.me/set_web"]
        ],
        ]
])
]);
}