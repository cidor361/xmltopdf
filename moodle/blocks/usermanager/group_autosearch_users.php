<?php
require_once('../../config.php');
require_once('lib.php');
//require_once('enrol_users_form.php');

global $DB, $USER, $COURSE, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
require_login($course, true);

$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/group_autosearch_users.php', array('id' => $course->id));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();
print(var_dump($COURSE));
/*
$mform = new group_autoserach_users();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$course->id);
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    $mform->display();

}else {
    $mform->display();

}
*/
echo $OUTPUT->footer();
//TODO: создать списки по полям
//TODO: создание группы в процессе подписки
