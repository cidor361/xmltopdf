<?php
require_once('../../config.php');
require_once('list_form.php');
require 'info.php';

$internal_courseid = $SESSION['internal_courseid'];
$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);
require_login($internal_courseid);
$PAGE->set_url('/blocks/coursefields/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('Мониторинг');
$PAGE->set_heading('Мониторинг');
$PAGE->set_context(context_course::instance($internal_courseid));

$number_of_records = $DB->count_records('block_coursefields');

$mform = new listform();
$mform->add_simple_text('Количество записей в БД', $number_of_records, null);

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();