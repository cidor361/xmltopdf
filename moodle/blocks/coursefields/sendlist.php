<?php
require_once('../../config.php');
require_once('constructor.php');
require 'info.php';

global $PAGE, $OUTPUT, $DB, $USER;
$internal_courseid = $_SESSION['internal_courseid'];
require_login($internal_courseid);

$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);

$PAGE->set_url('/blocks/coursefields/sendlist.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($internal_courseid));

if ($DB->record_exists('block_coursefields',array('internal_courseid' => $internal_courseid))) {
    $Object = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid), '*', MUST_EXIST);
        }
$json = get_json_for_sending($Object, $info);
$Object = json_decode($Object->json);
$mform = create_simple_field($Object, $USER->id, $context);

if ($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/coursefields/list.php');
    redirect($url);
} else if ($data = $mform->get_data()) {
//    add_course($info['address'], $json, $info['keyfile'], $info['certfile']);
    $curl = curl_init('https://preprod.oeplatform.ru/ru/api/cources/v0/course/');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_USERPWD, 'riapolov@vsu.ru : vsu_2019');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt_array($curl, [
//         CURLOPT_REFERER => 'https://mooc.vsu.ru/',
//         CURLOPT_SSL_VERIFYPEER => 1,
//         CURLOPT_SSL_VERIFYHOST => 2,
//         CURLOPT_CAINFO => $certfile,
//         CURLOPT_SSLKEY => $keyfile,
//         CURLOPT_POST => 1,
//         CURLOPT_POSTFIELDS => [
//    ]);
    $resp = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($status != 200) {
        die("Error: call to URL $url failed with status $status, response $resp, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);
} else {

}

echo $OUTPUT->header();
$mform->display();
//echo var_dump($json);
echo $OUTPUT->footer();
