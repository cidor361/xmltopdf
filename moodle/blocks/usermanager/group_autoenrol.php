<?php
require_once('../../config.php');
require_once('lib.php');
require_once('group_autoenrol_form.php');

global $DB, $USER, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
require_login($course, true);

$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/group_autoenrol.php', array('id' => $course->id));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();

$groups = $SESSION->groups;
$ids = get_user_field_ids();

$groups_of_users = new stdClass();
foreach ($groups as $group){
    $sql = "SELECT * FROM mdl_block_vsucourse_new WHERE id='".$group."';";
    $disciplin_with_number = $DB->get_records_sql($sql);
    foreach ($disciplin_with_number as $key=>$disciplin) {
        if($disciplin->specialisation != null) {
            $groups_of_users->{$key} = search_vsu_fields_users_per_disciplin($ids, $disciplin);
        }
    }
}

$SESSION->groups_of_users = $groups_of_users;

$mform = new group_autoenrol_form();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/usermanager/group_autosearch_users.php');
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    $application_report = new stdClass();
    $application_report->created = time();
    $application_report->modified = 0;
    $application_report->required_user = $USER->id;
    $application_report->status = 0001;
    //$application_id = $DB->insert_record('block_usermanager_applications', $application_report);

    foreach ($groups_of_users as $group_key=>$group) {
        foreach ($group as $user_key=>$user){
            $user_report = new stdClass();
            $user_report->application_id = $application_id;
            $user_report->user_id = $user;
            if (enrol_user_manual($course->id, $user->id)) {
                $users_report->status = 01;
                $groups_of_users->{$group_key}->{$user_key}->enrolled = true;
            } else {
                $users_report->status = 00;
            }
            //$DB->insert_record('block_usermanager_users', $user_report);
            //TODO: тестированеи логгирования
            //TODO: Создание группы пользователей
        }
    }
    $SESSION->groups_of_users = $groups_of_users;
    $mform->display();

}else {
    $mform->display();

}

echo $OUTPUT->footer();
//TODO: создание группы в процессе подписки
