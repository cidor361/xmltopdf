<?php
require_once('../../config.php');
require_once('constructor.php');
require 'info.php';

global $PAGE, $OUTPUT, $DB, $USER;
$internal_courseid = $_SESSION['internal_courseid'];
require_login($internal_courseid);

$PAGE->set_url('/blocks/coursefield/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($internal_courseid));

$Object = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid), '*', MUST_EXIST);
$json = $Object->json;
$Object = get_obj_from_json($Object->json, $internal_courseid, $Object->id);

$mform = create_simple_field($Object, $USER);

if ($mform->is_cancelled()) {

} else if ($data = $mform->get_data()) {
    add_course($info['address'], $json);
} else {

}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();