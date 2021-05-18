<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    block_usermanager
 * @category   block
 * @copyright  2021 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('lib.php');
require_once('group_autoenrol_form.php');
require_once($CFG->dirroot.'/group/lib.php');

require_once('connect.php');

global $DB, $USER, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
$courseid = $course->id;
require_login($course, true);

$coursecontext = context_course::instance($courseid);
if (!has_capability('block/usermanager:manageuser', $coursecontext)) {
    die(get_string('access_error', 'block_usermanager'));
}

$PAGE->set_context($coursecontext);
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/group_autoenrol.php', array('id' => $courseid));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();

//Get and parse group information from group_autosearch_users.php
$groups = $SESSION->groups;
$ids = get_user_field_ids();
$groups_of_users_per_disciplin = new stdClass();
$moodle_group_name = new stdClass();
$moodle_group_description = new stdClass();

////Should be uncomment when oracle integration will be removed
//foreach ($groups as $group){
//$sql = "SELECT * FROM mdl_block_vsucourse_new WHERE id='".$group."';";
//$disciplin_with_number = $DB->get_records_sql($sql);
$disciplins_with_number = get_semestr_of_subject_oci_old($conn, $courseid);

foreach ($disciplins_with_number as $disciplin_id => $disciplin) {

    if (group_selected($groups, $disciplin->id)) {

        if ($disciplin->specialisation == '-') {
            $groups_of_users_per_disciplin->{$disciplin_id} = search_vsu_fields_users_per_disciplin_without_specialisation($ids, $disciplin);
        } else {
            $groups_of_users_per_disciplin->{$disciplin_id} = search_vsu_fields_users_per_disciplin($ids, $disciplin);
        }
        //Reformat students plan groups to academic groups
        $groups_of_users_per_disciplin = format_users_to_groups($ids, $groups_of_users_per_disciplin);

    }
}
//}

//Send group information to group_autoenrol_form.php and create form
$SESSION->groups_of_users = $groups_of_users_per_disciplin;

$mform = new group_autoenrol_form();

if ($mform->is_cancelled()) {
    //If user press "cancel", he will be redirected to another page
    $url = new moodle_url('/blocks/usermanager/group_autosearch_users.php');
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    //If user press "submit" button, all users in groups will be enrolled and
    //this action will be logged
    $error_count = 0;
    //TODO: добавить получение информации для флага "подписан"

    foreach ($groups_of_users_per_disciplin as $disciplin_id=>$groups_of_users) {
        foreach ($groups_of_users as $group_id => $group_of_user) {
            //Create application report for logging in db (block_usermanager_applies)
            $moodle_group_id = $disciplin_id . '_' . $group_id;
            $application_report = new stdClass();
            //$application_report->group_id = $group_num;
            $application_report_group_id = $moodle_group_id;
            $application_report->created = time();
            $application_report->modified = 0;
            $application_report->required_user = $USER->id;
            $application_report->status = 0001;
            //$application_id = $DB->insert_record('block_usermanager_applies', $application_report);

            //Create group in moodle course
            $moodle_group_info = groups_get_group_by_idnumber($courseid, $moodle_group_id);
            if (!$moodle_group_info) {
                $moodle_group_name = '';
                $moodle_group_name .= $group_id . ' группа ';
                $moodle_group_name .= $disciplins_with_number->{$disciplin_id}->speciality;
                $moodle_group_name .= ' (' . $disciplins_with_number->{$disciplin_id}->step . ', ';
                $moodle_group_name .= $disciplins_with_number->{$disciplin_id}->st_form . ')';
                $moodle_group_name .= $disciplins_with_number->{$disciplin_id}->year;

                $moodle_group_description = '';
                $moodle_group_description .= $group_id . ' группа ' . '</br>';
                $moodle_group_description .= $disciplins_with_number->{$disciplin_id}->faculty . '</br>';
                $moodle_group_description .= $disciplins_with_number->{$disciplin_id}->speciality_code . '</br>';
                $moodle_group_description .= $disciplins_with_number->{$disciplin_id}->speciality . '</br>';
                $moodle_group_description .= $disciplins_with_number->{$disciplin_id}->specialisation . '</br>';
                $moodle_group_description .= $disciplins_with_number->{$disciplin_id}->step . '</br>';
                $moodle_group_description .= $disciplins_with_number->{$disciplin_id}->year . '</br>';

                $moodle_group_data = new stdClass();
                $moodle_group_data->courseid = $courseid;
                $moodle_group_data->idnumber = $moodle_group_id;
                $moodle_group_data->name = $moodle_group_name;
                $moodle_group_data->description = $moodle_group_description;
                $moodle_group_data->descriptionformat = FORMAT_HTML;
                $moodle_group_id = groups_create_group($moodle_group_data);
            } else {
                $moodle_group_id = $moodle_group_info->id;
            }

            foreach ($group_of_user as $user) {
                //Create user report for logging in db (block_usermanager_users)
                //and enrol user
                $userid = $user->id;
                $user_report = new stdClass();
                $user_report->application_id = $application_id;
                $user_report->user_id = $userid;
                if (!groups_is_member($moodle_group_id, $userid)) {
                    if (enrol_user_manual($courseid, $userid, $moodle_group_id)) {
                        //Status 01 - success
                        $user_report->status = 01;
                        $groups_of_users_per_disciplin->{$disciplin_id}->{$group_id}->{$userid}->enrolled = true;
                    } else {
                        //Status 00 - error
                        $user_report->status = 00;
                        $groups_of_users_per_disciplin->{$disciplin_id}->{$group_id}->{$userid}->enrolled = false;
                        $error_count += 1;
                    }
                }
                //$DB->insert_record('block_usermanager_users', $user_report);
                //TODO: тестированеи логгирования
            }
        }
    }
    //TODO: Значки для флага "подписан"
    //$SESSION->groups_of_users = $groups_of_users_new; //for update enrolled information in form
    //$mform->display();  //uncomment when will remake to pngs

    //Processing errors and show button "return to course"
    if ($error_count > 0) {
        echo get_string('unsuccess_enrol', 'block_usermanager').' ('.$error_count.')</br>';
    } else {
        echo get_string('success_enrol', 'block_usermanager').'</br>';
    }
    $url = new moodle_url('course/view.php$id=', array('id' => $courseid));
    echo html_writer::link($url,get_string('return_to_coursepage', 'block_usermanager'));

}else {
    $mform->display();
}

echo $OUTPUT->footer();
