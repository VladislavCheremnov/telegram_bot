<?php

//phpinfo();

$link = mysqli_connect('mysql', 'root', 'root');
if (!$link) {
    die('Ошибка соединения: ' . mysqli_error());
}
echo 'Успешно соединились';
mysqli_close($link);

?>