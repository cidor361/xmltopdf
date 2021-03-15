<?php
require_once('../../config.php');
require_once('lib.php');
require_once('manual_search_users_form.php');

global $DB, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
require_login($course, true);

$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/manual_search_users.php', array('id' => $course->id));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();

$mform = new students_form();

$ids = get_user_field_ids();
$first_data = new stdClass();
$first_data->facultets = get_facultet_names($ids);
$first_data->num_course = get_num_course_name($ids);
$first_data->edu_forms = get_edu_forms_name($ids);
$first_data->edu_level = get_edu_level_name($ids);
$first_data->edu_specialites = get_edu_specialites_name($ids);
$SESSION->first_data = $first_data;

if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$course->id);
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    $data = prepare_data_one($fromform, $first_data);
    $users = search_vsu_fields_users($ids, $data);
    $SESSION->second_data = $users;
    $url = new moodle_url('/blocks/usermanager/enrol_users.php');
    redirect($url);

}else {
    $mform->display();
}

echo $OUTPUT->footer();

//TODO: создать списки по полям
//TODO: создание группы в процессе подписки
