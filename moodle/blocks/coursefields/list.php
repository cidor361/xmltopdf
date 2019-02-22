<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/coursefield/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));

$mform = new listform();
$mform->add_textfield('title', 'tyty');
$mform->add_textfield('title2', 'text');

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();