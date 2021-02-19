<?php

require_once('../../config.php');
//require_once('lib.php');
require_once('global_students_form.php');

global $DB;

//$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
$course = $DB->get_record('course',array('id'=>3777));
require_login($course, true);


//$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/global_students.php', array('id' => 3777));
//$PAGE->set_url('/blocks/vsucourse/global_students.php', array('id' => $course->id));
$PAGE->navbar->add(get_string('pluginname', 'block_vsucourse'));

$PAGE->set_title(get_string('pluginname', 'block_vsucourse'));
$PAGE->set_heading(get_string('pluginname', 'block_vsucourse'));

echo $OUTPUT->header();


$mform = new students_form();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$course->id);
    redirect($url);
} else if ($fromform = $mform->get_data()) {
    $stmform = new students_show_form();
    //$users = search_vsu_users($field_ids, $fromform);
    $stmform->display();
} else {
    //$mform->set_data($fields);
    $mform->display();
}

echo $OUTPUT->footer();


//TODO: создать списки по полям
//TODO: создание группы в процессе подписки
