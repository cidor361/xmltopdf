<?php
require_once('../../config.php');
require_once('lib.php');
require_once('enrol_users_form.php');

global $DB, $USER, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
require_login($course, true);

$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/search_users.php', array('id' => $course->id));
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
    $users_report->created = time();
    $users_report->modified = 0;
    $users_report->required_user = $USER->id;
    $users_report->status = 0001;
    $DB->insert_record('block_usermanager_applications', $users_report);
    $application = $DB->get_record('block_usermanager_applications', array("created" => $users_report->created));
    $application_id = $application->created;

    $user_report = new stdClass();
    foreach ($users as $user) {
        if (enrol_user_manual($course->id, $user) == true) {
            $user_report->application_id = $application_id;
            $user_report->user_id = $user;
            $DB->insert_record('block_usermanager_users', $user_report);
        } else {

        }

    }
    $mform->display();
}else {
    $mform->display();
}

echo $OUTPUT->footer();

//TODO: создать списки по полям
//TODO: создание группы в процессе подписки
