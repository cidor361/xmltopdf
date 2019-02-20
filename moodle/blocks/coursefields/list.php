<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/coursefield/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));

echo $OUTPUT->header();
echo $OUTPUT->footer();