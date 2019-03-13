<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $DB;

//TODO: send courseid (after action with form
//require_login($courseid);

$courseid = $_GET['id'];
$PAGE->set_url('/blocks/coursefield/list.php'.'?id='.$courseid);
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($courseid));
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$exist = $DB->record_exists('block_coursefields', array('courseid' => $courseid));
if ($exist = 1) {
    $object = $DB->get_record('block_coursefields', array('courseid' => $courseid), '*', MUST_EXIST);
}
$mform = new listform();


//TODO: default values ( + when they must be added - before or after first time)

if($mform->is_cancelled()) {

} else if ($mform->get_data()) {
//    $object = new stdClass();
//    $object->id = $courseid;
//    $object->courseid = $courseid;
//    $object->partnerid = '123';
//    $object->external_url = 'qq.ru';
//    $object->direction = '31564783265667695553';
//    $object->institution = 'dghdghadfvgsf';
//    $object->duration = '666';
//    $object->cert = 'true';
//    $object->business_version = '20190201';
    $object = $mform->get_data();
    if($exist = 0) {
        $DB->insert_record('block_coursefields', $object, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefield', $object, '*', MUST_EXIST);
    }

} else {

}

$mform->add_textfield(get_string('partnerid', 'block_coursefields'), $object->partnerid, 'partnerid');
$mform->add_textfield(get_string('title', 'block_coursefields'), $course->fullname, 'title');
$mform->add_data_selector(get_string('started_at', 'block_coursefields'), $year, $month, $date, 'started_at');
$mform->add_data_selector(get_string('finished_at', 'block_coursefields'), $year, $month, $date, 'finished_at');
$mform->add_textfield(get_string('description', 'block_coursefields'), $course->summary, 'description');
$mform->add_textfield(get_string('external_url', 'block_coursefields'), $object->external_url, 'external_url');
$mform->add_textfield(get_string('direction', 'block_coursefields'), $object->direction, 'direction');
$mform->add_textfield(get_string('institution', 'block_coursefields'), $object->institution, 'institution');
$mform->add_textfield(get_string('duration', 'block_coursefields'), $object->duration, 'duration');
$mform->add_selectwithlink(get_string('duration', 'block_coursefields'),'yes');
$mform->add_textfield(get_string('business_version', 'block_coursefields'), $object->business_version, 'business_version');
$mform->add_textfield(get_string('promo_url', 'block_coursefields'), 'http://URL.ru', 'promo_url');

//$mform->addRule('fullname', get_string('missingfullname'), 'required', null, 'client');

$mform->add_act_button();
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();