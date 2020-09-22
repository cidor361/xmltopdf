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

require_once('info.php');

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
            "Authorization: Basic "
        ),
    ));


    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

}

//echo get_config('online.edu.ru/.well-known/openid-configuration');

upload_course($info['address'], $info['certfile'], $info['keyfile'],
                );