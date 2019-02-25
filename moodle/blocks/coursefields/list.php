<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $DB;

$courseid = $_GET['id'];
$PAGE->set_url('/blocks/coursefield/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($courseid));

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$mform = new listform();
$mform->add_textfield(get_string('partnerid', 'block_coursefields'), 'Непонятно???');
$mform->add_textfield(get_string('title', 'block_coursefields'), $course->fullname);
$mform->add_data_selector(get_string('started_at', 'block_coursefields'), $year, $month, $date);
$mform->add_data_selector(get_string('finished_at', 'block_coursefields'), $year, $month, $date);
$mform->add_textfield(get_string('description', 'block_coursefields'), $course->summary);
$mform->add_textfield(get_string('external_url', 'block_coursefields'), 'https://www.moodle.com');
$mform->add_textfield(get_string('direction', 'block_coursefields'), '');
$mform->add_textfield(get_string('institution', 'block_coursefields'), 'text');
$mform->add_textfield(get_string('duration', 'block_coursefields'), 'text');
$mform->add_selectwithlink(get_string('duration', 'block_coursefields'),'yes');
$mform->add_textfield(get_string('business_version', 'block_coursefields'), 'text');
$mform->add_textfield(get_string('promo_url', 'block_coursefields'), 'http://URL.ru');

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();