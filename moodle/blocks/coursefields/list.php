<?php
require(__DIR__.'../../config.php');
require_once(__DIR__.'constructor.php');
require_once(__DIR__.'info.php');

$internal_courseid = $SESSION->internal_courseid;
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
    $SESSION->id = $Object->id;
    $SESSION->external_courseid = $Object->external_courseid;
    $Object = get_obj_from_json($Object);
    $login_password = 'riapolov@vsu.ru:vsu_2019';
    $external_status = get_grade_status_course($info['get_status_url'], $SESSION->external_courseid, $login_password);
} else {
    $Object = create_start_object($course, $info, $USER);
}

//$mform = create_full_field($Object);

if($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$internal_courseid);
    redirect($url);
} else if ($formdata = $mform->get_data()) {
    $Object = get_form_data($Object, $formdata);
    $Object_for_db = add_data_for_db($Object, $internal_courseid, $external_courseid, $SESSION->id);
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
echo html_writer::link(new moodle_url($info['sendlisturl']), 'Для отправки курса нажмите здесь');
//echo '<br>Если хотите отправить данный курс в СЦОС, нажмите "<a href='.$url.'>Отправить</a>"<br/>';
echo $OUTPUT->footer();
