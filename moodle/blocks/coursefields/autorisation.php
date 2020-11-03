<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    block_coursefields
 * @category   block
 * @copyright  2008 Kim Bloggs
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('info.php');
require_once('lib.php');

function get_config($url) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'auth.online.edu.ru/realms/portfolio/.well-known/openid-configuration',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    curl_close($curl);
//    $response = json_decode($response);
    return $response;
}

function get_token_password($url, $client_id, $client_secret, $username, $password) {
    $postData = '&grant_type=password&client_id='.$client_id.'&client_secret='.$client_secret.
        '&username='.$username.'&password='.$password;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
//    $data = json_decode($data);
    return $data;
}

function point_of_auth($url, $client_id, $response_type, $redirect_url) {
    $url = $url.'?client_id='.$client_id;
    $url = $url.'&response_type='.$response_type;
    $url = $url.'&redirect_url='.$redirect_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);

    echo $data;
}

function upload_course($url, $certfile, $keyfile, $data, $login_password) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_SSLCERT => $certfile,
        CURLOPT_SSLKEY => $keyfile,
        CURLOPT_HTTPHEADER => array(
            "Referer: https://mooc.vsu.ru/",
            "Content-Type: application/json",
            "Authorization: Basic cmlhcG9sb3ZAdnN1LnJ1OnZzdV8yMDE4"
        ),
    ));


    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

}

//echo get_config('online.edu.ru/.well-known/openid-configuration');

//echo add_course("{\n\t\"partnerId\": \"f2d0a7b9-a1f0-4816-b519-434d193477c8\",\n\t\"package\": {\n\t\t\"items\": [{\n\t\t\t\"lectures\": 19,\n\t\t\t\"direction\": [\n\t\t\t\t\"55.05.05\"\n\t\t\t],\n\t\t\t\"description\": \"Тестовый курс\",\n\t\t\t\"language\": \"ru\",\n\t\t\t\"title\": \"ТестКурс»\",\n\t\t\t\"competences\": \"ЗНАТЬ основные эстетические и идеологические принципы, лежащие в основе детского советского кинематографа\\nУМЕТЬ осуществлять анализ фильма в зависимости от контекста времени, и эстетики в которой он снят\\nВЛАДЕТЬ первичными навыками написания рецензий и обзорных статей по вопросам детского кинематографа\",\n\t\t\t\"results\": \"\",\n\t\t\t\"hours_per_week\": \"7\",\n\t\t\t\"image\": \"https://mooc.tspu.edu.ru/pluginfile.php/108/course/summary/Zastavka_na_kurs.jpg\",\n\t\t\t\"cert\": \"true\",\n\t\t\t\"promo_url\": \"https://www.youtube.com/watch?v=gWn4f-5w0A0\",\n\t\t\t\"promo_lang\": \"ru\",\n\t\t\t\"subtitles_lang\": \"\",\n\t\t\t\"estimation_tools\": \"\",\n\t\t\t\"proctoring_service\": \"\",\n\t\t\t\"sessionid\": \"\",\n\t\t\t\"started_at\": \"2019-03-25\",\n\t\t\t\"finished_at\": \"2021-04-22\",\n\t\t\t\"enrollment_finished_at\": \"2019-03-25\",\n\t\t\t\"teachers\": [{\n                \"image\":\"https://mooc.tspu.edu.ru/page/img/author1.jpg\",\n                \"display_name\":\"Ряполов Михаил Павлович\",\n                \"description\":\"Преподаватель по курсу веб-администрирование\"\n            }\n                ],\n\t\t\t\"duration\": {\n\t\t\t\t\"code\": \"week\",\n\t\t\t\t\"value\": 4\n\t\t\t},\n\t\t\t\"business_version\": 1,\n\t\t\t\"institution\": \"e7b0c114-96ba-4722-be42-c1def06445ff\",\n\t\t\t\"external_url\": \"https://mooc.vsu.ru/course/view.php?id=98\"\n\t\t}]\n\t}\n}",
//    'riapolov@vsu.ru:vsu_2018');

//upload_course($info['address'], $info['certfile'], $info['keyfile'],
//    "{\n\t\"partnerId\": \"f2d0a7b9-a1f0-4816-b519-434d193477c8\",\n\t\"package\": {\n\t\t\"items\": [{\n\t\t\t\"lectures\": 19,\n\t\t\t\"direction\": [\n\t\t\t\t\"55.05.05\"\n\t\t\t],\n\t\t\t\"description\": \"Тестовый курс\",\n\t\t\t\"language\": \"ru\",\n\t\t\t\"title\": \"ТестКурс»\",\n\t\t\t\"competences\": \"ЗНАТЬ основные эстетические и идеологические принципы, лежащие в основе детского советского кинематографа\\nУМЕТЬ осуществлять анализ фильма в зависимости от контекста времени, и эстетики в которой он снят\\nВЛАДЕТЬ первичными навыками написания рецензий и обзорных статей по вопросам детского кинематографа\",\n\t\t\t\"results\": \"\",\n\t\t\t\"hours_per_week\": \"7\",\n\t\t\t\"image\": \"https://mooc.tspu.edu.ru/pluginfile.php/108/course/summary/Zastavka_na_kurs.jpg\",\n\t\t\t\"cert\": \"true\",\n\t\t\t\"promo_url\": \"https://www.youtube.com/watch?v=gWn4f-5w0A0\",\n\t\t\t\"promo_lang\": \"ru\",\n\t\t\t\"subtitles_lang\": \"\",\n\t\t\t\"estimation_tools\": \"\",\n\t\t\t\"proctoring_service\": \"\",\n\t\t\t\"sessionid\": \"\",\n\t\t\t\"started_at\": \"2019-03-25\",\n\t\t\t\"finished_at\": \"2021-04-22\",\n\t\t\t\"enrollment_finished_at\": \"2019-03-25\",\n\t\t\t\"teachers\": [{\n                \"image\":\"https://mooc.tspu.edu.ru/page/img/author1.jpg\",\n                \"display_name\":\"Ряполов Михаил Павлович\",\n                \"description\":\"Преподаватель по курсу веб-администрирование\"\n            }\n                ],\n\t\t\t\"duration\": {\n\t\t\t\t\"code\": \"week\",\n\t\t\t\t\"value\": 4\n\t\t\t},\n\t\t\t\"business_version\": 1,\n\t\t\t\"institution\": \"e7b0c114-96ba-4722-be42-c1def06445ff\",\n\t\t\t\"external_url\": \"https://mooc.vsu.ru/course/view.php?id=98\"\n\t\t}]\n\t}\n}");

//echo $info['address'];
print("qq");