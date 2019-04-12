<?php

require_once('../../config.php');
require_once('constructor.php');

global $PAGE, $OUTPUT, $DB;
$courseid = $_SESSION['courseid'];
require_login($courseid);

$PAGE->set_url('/blocks/coursefield/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($courseid));
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$courseobject = $DB->get_record('block_coursefields_main', array('courseid' => $courseid), '*', MUST_EXIST);
$teacherObject = $DB->get_record('block_coursefields_teacher', array('courseid' => $courseid), '*', MUST_EXIST);
$coursetransferObject = $DB->get_record('block_coursefields_coursetr', array('courseid' => $courseid), '*', MUST_EXIST);

$mform = createSimpleForm($courseobject, $teacherObject, $coursetransferObject);

if ($mform->is_cancelled()) {

} else if ($data = $mform->get_data()) {

} else {

}

$url = new moodle_url('/blocks/coursefields/sendlist.php');
echo $OUTPUT->header();
$mform->display();
echo sendXMLObject($courseid, $DB);
echo $OUTPUT->footer();