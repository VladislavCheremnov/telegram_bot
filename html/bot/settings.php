<?php
/* - PMA_HOST=mysql
    - PMA_USER=root
    - PMA_PASSWORD=root */
    
define('MYSQL_SERVER', 'mysql');    
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', 'root');
define('MYSQL_DB', 'tg_base');

function db_connect(){
    $connect = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB
        ) // Собственно переменная для подключения к БД
        or die("Error: ".mysqli_error($connect)); // Если есть проблемы с подключением - выведет ошибку.
    if(!mysqli_set_charset($connect, "utf8mb4")){ 
        print("Error: ".mysqli_error($connect));  // Если не будет кодировки - выведет ошибку.
    }
    return $connect;
}

$connect = db_connect();



?>