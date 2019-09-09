<?php
require_once('../../config.php');
require_once('constructor.php');
require 'info.php';

global $PAGE, $OUTPUT, $DB, $USER;
$internal_courseid = $_SESSION['internal_courseid'];
require_login($internal_courseid);
$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);

if (is_user_student($context, $USER->id)) {
    $url = new moodle_url('/blocks/coursefields/sendlist.php');
    redirect($url);
}

$course = $DB->get_record('course', array('id' => $internal_courseid), '*', MUST_EXIST);
$internal_courseid = $course->id;

$PAGE->set_url('/blocks/coursefields/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($internal_courseid));
$course = $DB->get_record('course', array('id' => $internal_courseid), '*', MUST_EXIST);


$exist = is_dbobj_exist($DB, $internal_courseid);

if ($exist) {
    $Object = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid));
    $Object = get_obj_from_json($Object->json, $internal_courseid, $Object->id);
} else {
    $Object = create_start_object($course, $info);
}
$mform = create_full_field($Object);

if($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$internal_courseid);
    redirect($url);
} else if ($formdata = $mform->get_data()) {
    $Object = reformat_formdata_for_db($Object, $formdata, '0000000000'.$Object->id);
    if ($exist) {
//        unset($Object->id);
//        $DB->set_field('block_coursefields', 'json', $Object->json);
        $DB->update_record('block_coursefields', $Object, $bulk=false);
        } else {
        $DB->insert_record('block_coursefields', $Object, '*', MUST_EXIST);
    }
} else {
//    get_course_status();
}

$url = new moodle_url($info['sendlisturl']);
echo $OUTPUT->header();
$mform->display();
echo '<br>Если хотите отправить данный курс в СЦОС, нажмите "Отправить"<br/>';
echo '<a href='.$url.'>Отправить</a>';
echo $OUTPUT->footer();