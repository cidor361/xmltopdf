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
$json = $Object->json;
$Object = get_obj_from_json($json, $internal_courseid, $Object->id);
$mform = create_simple_field($Object, $USER->id, $context);

if ($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/coursefields/list.php');
    redirect($url);
} else if ($data = $mform->get_data()) {
    add_course($info['address'], $json, $info['keyfile'], $info['certfile']);
} else {
//    get_course_status();
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();