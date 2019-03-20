<?php
require_once('../../config.php');
require_once('list_form.php');
//require_once('constructor.php');

global $PAGE, $OUTPUT, $DB;
//require_login($courseid);

$courseid = $_GET['id'];        //TODO: оптимизация
if($courseid == null) {
    $courseid = $_SESSION['courseid'];
}
$PAGE->set_url('/blocks/coursefield/list.php'.'?id='.$courseid);
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($courseid));
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$exist = $DB->record_exists('block_coursefields', array('courseid' => $courseid));
if ($exist == 1) {
    $courseobject = $DB->get_record('block_coursefields', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $courseobject = createField();
}
$mform = new listform();    //TODO: проверить совпадение полей с базой
$mform->add_textfield(get_string('partnerid', 'block_coursefields'), $courseobject->partnerid, 'partnerid');
$mform->add_textfield(get_string('title', 'block_coursefields'), $course->fullname, 'title');
$mform->add_data_selector(get_string('started_at', 'block_coursefields'), $year, $month, $date, 'started_at');
$mform->add_data_selector(get_string('finished_at', 'block_coursefields'), $year, $month, $date, 'finished_at');
$mform->add_textfield(get_string('description', 'block_coursefields'), $course->summary, 'description');
$mform->add_textfield(get_string('external_url', 'block_coursefields'), $courseobject->external_url, 'external_url');
$mform->add_textfield(get_string('direction', 'block_coursefields'), $courseobject->direction, 'direction');
$mform->add_textfield(get_string('institution', 'block_coursefields'), $courseobject->institution, 'institution');
$mform->add_textfield(get_string('duration', 'block_coursefields'), $courseobject->duration, 'duration');
$mform->add_selectwithlink(get_string('duration', 'block_coursefields'),'yes');
$mform->add_textfield(get_string('business_version', 'block_coursefields'), $courseobject->business_version, 'business_version');
$mform->add_textfield(get_string('promo_url', 'block_coursefields'), 'http://URL.ru', 'promo_url');

//TODO: добавить закрытые для записи поля
//TODO: добавить обязательные поля
//$mform->addRule('fullname', get_string('missingfullname'), 'required', null, 'client');

$mform->add_act_button();

if($mform->is_cancelled()) {

} else if ($object = $mform->get_data()) {
    $object->courseid = $courseid;
    if ($exist == null) {
        $DB->insert_record('block_coursefields', $object, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefields', $object);
    }
} else {
$_SESSION['courseid'] = $courseid;
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();