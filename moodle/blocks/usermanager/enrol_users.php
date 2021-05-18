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
require_once('enrol_users_form.php');

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
$PAGE->set_url('/blocks/usermanager/search_users.php', array('id' => $courseid));
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
    $DB->insert_record('block_usermanager_applies', $users_report);
    $application = $DB->get_record('block_usermanager_applies', array("created" => $users_report->created));
    $application_id = $application->created;

    //TODO: создание группы в процессе подписки
    $user_report = new stdClass();
    $error_counter = 0;
    foreach ($users as $user) {
        if (enrol_user_manual($course->id, $user) == true) {
            $user_report->application_id = $application_id;
            $user_report->user_id = $user;
            $DB->insert_record('block_usermanager_users', $user_report);
        } else {
            //TODO: Расширенная обработка ошибок
            $error_counter += 1;
        }

    }
    echo 'Произошло '.$error_counter.' ошибок в процессе подписки';
    $mform->display();
}else {
    $mform->display();
}

echo $OUTPUT->footer();
