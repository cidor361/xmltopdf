<?php
require_once('../../config.php');
require_once('lib.php');
require_once('enrol_users_form.php');

global $DB, $SESSION;

//$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
$course = $DB->get_record('course',array('id'=>3777));
require_login($course, true);

//$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/enrol_users.php', array('id' => 3777));
//$PAGE->set_url('/blocks/vsucourse/search_users.php', array('id' => $course->id));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();

$mform = new students_form();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/usermanager/search_users.php');
    redirect($url);
} else if ($fromform = $mform->get_data()) {
    $users = array();
    foreach ($fromform as $user) {
        if ($user != 0) {
            array_push($users, (int)$user);
        }
    }

    $users_report = new stdClass();
    foreach ($users as $user) {
        enrol_user_manual(3777, $user, 5);

    }
    $mform->display();
}else {
    $mform->display();
}

echo $OUTPUT->footer();

//TODO: создать списки по полям
//TODO: создание группы в процессе подписки
