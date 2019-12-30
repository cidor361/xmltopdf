<?php
require('info.php');

function get_config($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($data);
    return $data;
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
    $data = json_decode($data);
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

//echo var_dump(get_token_password($info['token_url'], 'mooc_vsu_ru', '7b9ff246-d7d9-48e9-83c6-4e51d985838d', 'riapolov@vsu.ru', 'vsu_2019'));
echo var_dump(get_token_password($info['token_url'], 'mooc_vsu_ru', '7b9ff246-d7d9-48e9-83c6-4e51d985838d', 'riapolov@vsu.ru', 'vsu_2018'));
//echo var_dump(point_of_auth($info['point_auth'], $config['client_id'], $config['response_type'], $config['redirect_url']));