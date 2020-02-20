<?php
require_once('../../config.php');
require_once('constructor.php');
require 'info.php';

global $PAGE, $OUTPUT, $DB, $USER;
$internal_courseid = $_SESSION['internal_courseid'];
$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);
require_login($internal_courseid);
if (is_user_student($context, $USER->id)) {
    $url = new moodle_url('/blocks/coursefields/sendlist.php');
    redirect($url);
}
$PAGE->set_url('/blocks/coursefields/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($internal_courseid));

$course = $DB->get_record('course', array('id' => $internal_courseid), '*', MUST_EXIST);
if (dbobj_exist($DB, $internal_courseid)) {
    $Object = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid));
    $_SESSION['id'] = $Object->id;
    $_SESSION['external_courseid'] = $Object->external_courseid;
    $Object = get_obj_from_json($Object);
//     $course_status = get_grade_status_course($info['get_status_url'], $_SESSION['external_courseid'])
} else {
    $Object = create_start_object($course, $info, $USER);
}

$mform = create_full_field($Object);

if($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$internal_courseid);
    redirect($url);
} else if ($formdata = $mform->get_data()) {
    $Object = get_form_data($Object, $formdata);
    $Object_for_db = add_data_for_db($Object, $internal_courseid, $external_courseid, $_SESSION['id']);
    if (dbobj_exist($DB, $internal_courseid)) {
        $DB->update_record('block_coursefields', $Object_for_db);
        } else {
        $DB->insert_record('block_coursefields', $Object_for_db, '*', MUST_EXIST);
    }
} else {
//    get_course_status();
}

$url = new moodle_url($info['sendlisturl']);
echo $OUTPUT->header();
$mform->display();
echo '<br>Если хотите отправить данный курс в СЦОС, нажмите "<a href='.$url.'>Отправить</a>"<br/>';
// echo var_dump($Object);
echo $OUTPUT->footer();
