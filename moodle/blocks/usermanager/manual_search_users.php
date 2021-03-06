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
require_once('manual_search_users_form.php');

global $DB, $SESSION;

$courseid = $SESSION->courseid;
$course = $DB->get_record('course',array('id' => $courseid));
require_login($course, true);

$coursecontext = context_course::instance($courseid);
if (!has_capability('block/usermanager:manageuser', $coursecontext)) {
    die(get_string('access_error', 'block_usermanager'));
}

$PAGE->set_context($coursecontext);
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/manual_search_users.php', array('id' => $courseid));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));
$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();

$mform = new students_form();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    //Get and prepare user data for search (in next page)
    $ids = get_user_field_ids();
    $data = new stdClass();
    //$instance = new \local_addition_vsu_data\profile_field_vsu\profile_field_method_vsu();
    $data->facultets = get_facultet_names($ids);
    //$data->facultets = $instance->get_facultet_names();
    $data->num_course = get_num_course_name($ids);
    //$data->num_course = $instance->get_num_course_name();
    $data->edu_forms = get_edu_forms_name($ids);
    //$data->edu_forms = $instance->get_edu_forms_name();
    $data->edu_level = get_edu_level_name($ids);
    //$data->edu_level = $instance->get_edu_level_name();
    $data->edu_specialites = get_edu_specialites_name($ids);
    //$data->edu_specialites = $instance->get_edu_specialites_name();

    $data = prepare_data_one($fromform, $data);
    $users = search_vsu_fields_users($ids, $data);
    $SESSION->users = $users;
    $url = new moodle_url('/blocks/usermanager/manual_enrol_users.php', array('courseid' => $courseid));
    redirect($url);

}else {
    $mform->display();
}

echo $OUTPUT->footer();

