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
$exist = is_dbobj_exist($DB, $internal_courseid);
if ($exist) {
    $Object_db = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid));
    $Object = get_obj_from_json($Object_db->json);
} else {
    $Object = create_start_object($course, $info);
}
$pseudo_courseid = '0000000000'.$internal_courseid;

if ($Object->external_courseid != $pseudo_courseid) {
    $_SESSION['external_courseid'] = $Object_db->external_courseid;
    $external_courseid = $Object_db->external_courseid;
} else {
    $_SESSION['pseudo_courseid'] = $pseudo_courseid;
}

$mform = create_full_field($Object);

if($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$internal_courseid);
    redirect($url);
} else if ($formdata = $mform->get_data()) {
    $Object = reformat_formdata_for_db($Object, $formdata, $internal_courseid, $pseudo_courseid);
   $Output_var = $Object;
    if ($exist) {
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
echo '<br><b>28 октября плагин был обновлён, советуем нажать кнопку "Сохранить" во избежании несоответствия данных в базе данных</b></br>';
echo '<br>Если хотите отправить данный курс в СЦОС, нажмите "Отправить"<br/>';
echo '<a href='.$url.'>Отправить</a></br>';
echo var_dump($Output_var);
echo $OUTPUT->footer();
