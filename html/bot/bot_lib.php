<?php

function add_user($connect, $username, $chat_id, $name, $old_id){  //Записываем данные в базу без пробелов.
    $username = trim($username);
    $chat_id = trim($chat_id);
    $name = trim($name);

    if($chat_id == $old_id)  //Проверка на айдишник пользователя. Если уже есть в базе, то не записываем.
        return false;
    $t = "INSERT INTO users (username, chat_id, name) VALUES ('%s', '%s', '%s')";

    $query = sprintf($t, mysqli_real_escape_string($connect, $username),    // Сама запись в столбцы таблицы.
                        mysqli_real_escape_string($connect, $chat_id),
                        mysqli_real_escape_string($connect, $name));
    $result = mysqli_query($connect, $query);
    if(!$result)
        die(mysqli_error($connect));     //Если есть ошибка, выводим текст ошибки.
    return true;      
}

function get_user($connect, $chat_id){      //Определяем старый айдишник пользователя.
    $query = sprintf("SELECT * FROM users WHERE chat_id=%d", (int)$chat_id);
    $result = mysqli_query($connect, $query);
    if(!$result)
        die(mysqli_error($connect));    //Опять таки проверка на получение данных.
    $get_user = mysqli_fetch_assoc($result);
    return $get_user;
}

function textlog($connect, $chat_id, $text){    //заносим данные в таблицу textlog

    if($chat_id == '')  //Если чат йади пустой, то ничего не делаем.
        return false;
    $t = "INSERT INTO textlog (chat_id, text) VALUES ('%s', '%s')";
    $query = sprintf($t, mysqli_real_escape_string($connect, $chat_id),
                            mysqli_real_escape_string($connect, $text));    //Записываем текст сообщения в колонку текст.
    $result = mysqli_query($connect, $query);

    if(!$result)
        die(mysqli_error($connect));
    return true;

}

?>