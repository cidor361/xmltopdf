<?php
require_once('../../config.php');
require_once('lib.php');
require_once('group_autoenrol_form.php');
require_once($CFG->dirroot.'/group/lib.php');

require_once('connect.php');

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

//Get and parse group information from group_autosearch_users.php
$groups = $SESSION->groups;
$ids = get_user_field_ids();
$groups_of_users = new stdClass();
$moodle_group_name = new stdClass();
$moodle_group_description = new stdClass();

//foreach ($groups as $group){
    //$sql = "SELECT * FROM mdl_block_vsucourse_new WHERE id='".$group."';";
    $disciplin_with_number = get_semestr_of_subject_oci_old($conn, $course);
    ////Should be uncomment when oracle integration will be removed
    //$disciplin_with_number = $DB->get_records_sql($sql);
    foreach ($disciplin_with_number as $key=>$disciplin) {
        if($disciplin->specialisation == '-') {
            $groups_of_users->{$key} = search_vsu_fields_users_per_disciplin_without_specialisation($ids, $disciplin);
        } else {
            $groups_of_users->{$key} = search_vsu_fields_users_per_disciplin($ids, $disciplin);
        }
        $moodle_group_name->{$key} = '';
        $moodle_group_name->{$key} .= $disciplin->speciality.' ('.$disciplin->step. ', '.$disciplin->st_form.')';
        $moodle_group_name->{$key} .= $disciplin->year;

        $moodle_group_description->{$key} = '';
        $moodle_group_description->{$key} .= $disciplin->faculty.'</br>';
        $moodle_group_description->{$key} .= $disciplin->speciality_code.'</br>';
        $moodle_group_description->{$key} .= $disciplin->speciality.'</br>';
        $moodle_group_description->{$key} .= $disciplin->specialisation.'</br>';
        $moodle_group_description->{$key} .= $disciplin->step.'</br>';
        $moodle_group_description->{$key} .= $disciplin->year.'</br>';

    }
    //echo var_dump($groups_of_users);
//}
//Reformat students plan groups to academic groups
$groups_of_users_new = new stdClass();
foreach ($groups_of_users as $group) {
    $groups_of_users_new = format_users_to_groups($ids, $groups_of_users_new, $group);
}

//Send group information to group_autoenrol_form.php and create form
$SESSION->groups_of_users = $groups_of_users_new;
//$SESSION->groups_of_users = $groups_of_users;
echo var_dump($groups_of_users);

$mform = new group_autoenrol_form();

if ($mform->is_cancelled()) {
    //If user press "cancel", he will be redirected to another page
    $url = new moodle_url('/blocks/usermanager/group_autosearch_users.php');
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    //If user press "submit" button, all users in groups will be enrolled and
    //this action will be logged
    $error_count = 0;

    foreach ($groups_of_users as $group_num=>$group) {
        //Create application report for logging in db (block_usermanager_applications)
        $application_report = new stdClass();
        $application_report->group_id = $group_num;
        $application_report->created = time();
        $application_report->modified = 0;
        $application_report->required_user = $USER->id;
        $application_report->status = 0001;
        //$application_id = $DB->insert_record('block_usermanager_applications', $application_report);

        //echo var_dump(groups_group_exists($group_num));
        //Create group in moodle course
        $moodle_group_info = groups_get_group_by_idnumber($course->id, $group_num);
        if (!$moodle_group_info) {
            $moodle_group_data = new stdClass();
            $moodle_group_data->courseid = $course->id;
            $moodle_group_data->idnumber = $group_num;
            $moodle_group_data->name = $moodle_group_name->{$group_num};
            $moodle_group_data->description = $moodle_group_description->{$group_num};
            $moodle_group_data->descriptionformat = FORMAT_HTML;
            $moodle_group_id = groups_create_group($moodle_group_data);
        } else {
            $moodle_group_id = $moodle_group_info->id;
        }

        foreach ($group as $user_num=>$user){
            //Create user report for logging in db (block_usermanager_users)
            //and enrol user
            $user_report = new stdClass();
            $user_report->application_id = $application_id;
            $user_report->user_id = $user->id;
            if (!groups_is_member($group_num, $user->id)) {
                if (enrol_user_manual($course->id, $user->id, $moodle_group_id)) {
                    //Status 01 - success
                    $user_report->status = 01;
                    $groups_of_users->{$group_num}->{$user_num}->enrolled = true;
                } else {
                    //Status 00 - error
                    $user_report->status = 00;
                    $groups_of_users->{$group_num}->{$user_num}->enrolled = false;
                    $error_count += 1;
                }
            }
            //$DB->insert_record('block_usermanager_users', $user_report);
            //TODO: тестированеи логгирования
        }
    }
    //$SESSION->groups_of_users = $groups_of_users; //for update enrolled information in form
    //$mform->display();  //uncomment when will remake to pngs

    //Processing errors and redirect to course main page after 10 sec
    if ($error_count > 0) {
        echo 'Подписка прошла с ошибками ('.$error_count.')</br>';
    } else {
        echo 'Все студенты успешно подписаны</br>';
    }
    $url = new moodle_url('course/view.php$id=', array('id' => $course->id));
    echo html_writer::link($url,'Вернуться на главную страницу курса');
}else {
    $mform->display();
}

echo $OUTPUT->footer();
