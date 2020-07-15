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
 * @package    block_coursefields
 * @category   block
 * @copyright  2020 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('checkfields_form.php');
require('info.php');
require('lib.php');
require_login();

$PAGE->set_url('/blocks/coursefields/checkfields.php');
//$PAGE->set_pagelayout('standart');
$PAGE->set_title('Поля курса');
//$PAGE->set_heading('Поля курса');
//$PAGE->set_context(context_course:instance($SESSION->courseid));
$internal_courseid = $SESSION->courseid;

$mform = new checkfields_form();

$exist = $DB->record_exists('block_coursefields', array('internal_courseid' => $internal_courseid));
if ($exist) {
    $fromdb = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid));
    $external_courseid = $fromdb->external_courseid;  //TODO: make course status!
    $toform = json_decode($fromdb->json);
}

if($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/coursefields/editfields.php');
    redirect($url);
} else if ($formdata = $mform->get_data()) {
    $url = $info['address'];
    $login_password = $info['loginpassword'];
    $json = get_json_for_sending($toform, $info, $external_courseid);
    if ($external_courseid == null) {
        $answer = add_course($url, $json, $login_password);
        $result = json_decode($answer);
        if ($result->course_id != null) {
            $todb = new stdClass();
            $todb->id = $fromdb->id;
            $todb->external_courseid = $result;
            $DB->update_record('block_coursefields', $todb);
            $result = get_string('success_upload_course', 'block_coursefields').' '.$result->course_id;
        } else {
            $result = get_string('error_upload_course', 'block_coursefields');
        }
    } else {
        $result = update_ext_course($url.'?course_id='.$external_courseid, $json, $info['loginpassword']); //TODO: make $url in info file!
    }
    $mform->set_data($toform);
    $mform->display();
} else {
    $mform->set_data($toform);
    $mform->display();
}

echo $OUTPUT->header();
echo $result.'</br>';
echo var_dump($answer);
echo var_dump($login_password);
//$json = get_json_for_sending($toform, $info, $external_courseid);  //for debugging
//echo var_dump(get_grade_status_course($info['get_status_url'].$response, $response, $info['loginpassword'])).'<b>Оценка</b></br>'; //for tests
echo $OUTPUT->footer();
