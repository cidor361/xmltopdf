<?php
require_once('../../config.php');
require_once('constructor.php');
require 'info.php';

global $PAGE, $OUTPUT, $DB, $USER;
$internal_courseid = $_SESSION['internal_courseid'];
$id = $_SESSION['id'];
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
$Object = get_obj_from_json($Object);
$mform = create_simple_field($Object, $USER->id, $context);
$json = get_json_for_sending($Object, $info);

if ($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/coursefields/list.php');
    redirect($url);
} else if ($data = $mform->get_data()) {
    $login_password = 'riapolov@vsu.ru:vsu_2019';
    $response = add_course($info['address'], $json, $login_password);
    $responseObj = json_decode($response);
    if ($responseObj->course_id != Null) {
        $response = '<b>Отправка курса прошла успешно! Id курса: </b>'.$responseObj->course_id;
        $Object_for_db->external_courseid = $responseObj->course_id;
        $Object_for_db->id = $id;
        $DB->update_record('block_coursefields', $Object_for_db);
        }

} else {

}

echo $OUTPUT->header();
$mform->display();
if (!empty($response)){
    echo $response.'</br>';}
// if (file_put_contents("test.txt", $json)){echo "Sucsess write file!";}else{echo "Fail write file!";}
echo $OUTPUT->footer();
