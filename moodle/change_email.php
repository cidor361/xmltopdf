<?php
/*
 * Скрипт для добавления нижнего подчеркивания в почты абитуриентов
 * Позволяет избежать ошибок при восстановлении паролей (одинаковые почты у разных учетных записей)
 * Требуется скопировать его в корневую папку Moodle и зайти на этот файл через web-интерфейс
 * Запустить скрипт может только администратор
 * Перед запуском нужно раскомментировать код в конце файла (без него не произойдет запись в БД)
 * ВАЖНО! скрипт работает при первой загрузке, не рекомендуется обновлять страницу несколько раз
 * ВАЖНО! во избежании случайных срабатываний настоятельно рекомендуется удалить скрипт после использования
 */

require_once('config.php');
global $DB;

if (!is_siteadmin()) {
    die('Вход в матрицу не получился</br>Вы не избранный:(');
}

$parametr = 'username';
$from_parametr = 'a000000';
$after_parametr = 'a999999';
$exept_email = 'noreply@vsu.ru';

$sql = "select id, email from mdl_user 
        where ".$parametr." between '".$from_parametr."' and '".$after_parametr.
            "' and email not like '".$exept_email."';";
$users = $DB->get_records_sql($sql);

echo 'Данные получены</br>';

foreach ($users as $id=>$user) {
    echo $id.' '.$users[$id]->email.' ';
    $users[$id]->email = '_'.$user->email;
    echo $users[$id]->email.'</br>';
}
echo 'Processing was successful</br>';


//Uncomment before use!
/*
$errors = 0;
foreach ($users as $user) {
    if (!$DB->update_record('user', $user)) {
        $errors++;
        echo $user->id.'</br>';
    }
}

if ($errors == 0) {
    echo 'Запись в БД прошла успешно';
} else {
    echo 'Произошло '.$errors.' ошибок';
}
*/
