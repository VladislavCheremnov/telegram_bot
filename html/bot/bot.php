<?php
    echo 'добрался';
    include('vendor/autoload.php'); //Подключаем библиотеку.
    include('menu.php'); //Меню бота.
    include('settings.php'); //Подключение БД.
    include('bot_lib.php'); //Функции отдельным файлом.

    use Telegram\Bot\Api;

    $telegram = new Api(); //Передаем токен
    $result = $telegram->getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

    $text = $result["message"]["text"]; //Текст сообщения
    $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
    $name = $result["message"]["from"]["username"]; //Юзернейм пользователя
    $first_name = $result["message"]["from"]["first_name"]; //Имя пользователя
    $last_name = $result["message"]["from"]["last_name"]; //Фамилия пользователя
    $get_user = get_user($connect, $chat_id); //Получаем пользователя, если есть в базе
    $old_id = $get_user['chat_id'];   //Храним айди пользователя если есть в бд.
    $username = $first_name . ' ' . $last_name;  //Просто склеил для удобства

    if($text == "/start"){

        $reply = "Привет!\nЭто новостной бот.\nЖми кнопку новости и выбери интересующию тебя категорию новостей.";

        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true,
         'one_time_keyboard' => false]); //keyboard - кнопки из перемменной меню. resize_keyboard - размер клавы одинаков на всех устройствах. one_time_keyboard - всегда показывает клаву.
         
         $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);

    } elseif($text == 'Привет!'){

        $reply = "Привет " . $first_name . " " . $last_name;
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true,
         'one_time_keyboard' => false]); //keyboard - кнопки из перемменной меню. resize_keyboard - размер клавы одинаков на всех устройствах. one_time_keyboard - всегда показывает клаву.
         
         $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);

    } elseif ($text == 'Новости') {

        $reply = 'Выберите категорию новостей.'; // Проваливаемся в меню с категориями новостей.

        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu2, 'resize_keyboard' => true,
        'one_time_keyboard' => true]);    

         $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);

    } elseif ($text == 'Россия') {
        $reply = "Россия: \n\n";
        $xml = simplexml_load_file('https://news.google.com/rss/topics/CAAqIQgKIhtDQkFTRGdvSUwyMHZNRFppYm5vU0FuSjFLQUFQAQ?hl=ru&gl=RU&ceid=RU%3Aru');    //XML гугл новостей рубрики Россия.
        $i = 0;
        foreach ($xml->channel->item as $item) {    //Ограничил до 5 последних новостей через форыч.
            $i++;
            if($i > 5) {
                break;
            }
            $reply .= "\xE2\x9E\xA1 " . $item->title . "\nДата: " . $item->pubDate . "(<a href='".$item->link."'>Читать полностью</a>)\n\n";            //$item отвечает за перемещение по тегам. 
        }

        $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode' => 'HTML', // Используем парс мод, чтобы телеграмм понял, что это html документ
            'disable_web_page_preview' => true, 'text' => $reply]);         // disable_web_page_preview - передает превью страницы.     Остальные рубрики сделаны так же.

    } elseif ($text == 'В мире') {
        $reply = "В мире: \n\n";
        $xml = simplexml_load_file('https://news.google.com/rss/topics/CAAqJggKIiBDQkFTRWdvSUwyMHZNRGx1YlY4U0FuSjFHZ0pTVlNnQVAB?hl=ru&gl=RU&ceid=RU%3Aru');
        $i = 0;
        foreach ($xml->channel->item as $item) {    
            $i++;
            if($i > 5) {
                break;
            }
            $reply .= "\xE2\x9E\xA1 " . $item->title . "\nДата: " . $item->pubDate . "(<a href='".$item->link."'>Читать полностью</a>)\n\n";           
        }

        $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode' => 'HTML', 
            'disable_web_page_preview' => true, 'text' => $reply]); 

    } elseif ($text == 'Бизнес') {
        $reply = "Бизнес: \n\n";
        $xml = simplexml_load_file('https://news.google.com/rss/topics/CAAqJggKIiBDQkFTRWdvSUwyMHZNRGx6TVdZU0FuSjFHZ0pTVlNnQVAB?hl=ru&gl=RU&ceid=RU%3Aru'); 
        $i = 0;
        foreach ($xml->channel->item as $item) {  
            $i++;
            if($i > 5) {
                break;
            }
            $reply .= "\xE2\x9E\xA1 " . $item->title . "\nДата: " . $item->pubDate . "(<a href='".$item->link."'>Читать полностью</a>)\n\n";    
        }

        $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode' => 'HTML', 
            'disable_web_page_preview' => true, 'text' => $reply]);      

    } elseif ($text == 'Наука и техника') {
        $reply = "Наука и техника: \n\n";
        $xml = simplexml_load_file('https://news.google.com/rss/topics/CAAqKAgKIiJDQkFTRXdvSkwyMHZNR1ptZHpWbUVnSnlkUm9DVWxVb0FBUAE?hl=ru&gl=RU&ceid=RU%3Aru'); 
        $i = 0;
        foreach ($xml->channel->item as $item) {  
            $i++;
            if($i > 5) {
                break;
            }
            $reply .= "\xE2\x9E\xA1 " . $item->title . "\nДата: " . $item->pubDate . "(<a href='".$item->link."'>Читать полностью</a>)\n\n";      
        }

        $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode' => 'HTML', 
            'disable_web_page_preview' => true, 'text' => $reply]);     

    }



add_user($connect, $username, $chat_id, $name, $old_id); // Записываем пользователя в бд.
textlog($connect, $chat_id, $text); //Записываем текст сообщений от пользователя в бд.

?>
