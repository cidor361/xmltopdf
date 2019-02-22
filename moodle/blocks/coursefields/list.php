<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/coursefield/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));

$mform = new listform();
$mform->add_textfield('partnerid', 'tyty');
$mform->add_textfield('title', 'text');
$mform->add_data_selector('started_at', '11.11.11');
$mform->add_data_selector('finished_at', '12.11.12');
$mform->add_textfield('description', 'text');
$mform->add_link('external_url', 'https://www.moodle.com');
$mform->add_textfield('direction', '');
$mform->add_textfield('institution', 'text');
$mform->add_textfield('duration', 'text');
$mform->add_selectwithlink('duration','yes');
$mform->add_textfield('business_version', 'text');
$mform->add_link('promo_url', 'URL');


echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();