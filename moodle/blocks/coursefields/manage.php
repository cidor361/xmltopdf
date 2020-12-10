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
require_once('manage_form.php');
require('info_test.php');
require('lib.php');

$PAGE->set_context(context_course::instance($SESSION->courseid));
if (!has_capability('block/coursefield:manage_data', $SESSION->context)) {
    return null;
}

$PAGE->set_url('/blocks/coursefields/mnage.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('Управление отправкой информации в СЦОС');
$PAGE->set_heading('Управление информацией');
//$PAGE->set_context(context_course:instance($SESSION->courseid));
echo $OUTPUT->header();

$internal_courseid = $SESSION->courseid;

$exist = $DB->record_exists('block_coursefields', array('internal_courseid' => $internal_courseid));
if ($exist) {
    $toform = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid),
        'external_courseid');
}

$course_status = get_grade_status_course($toform->external_courseid,
    'riapolov@vsu.ru:vsu_2018', $info);
$course_status = json_decode($course_status);
$toform->get_grade_status_course = $course_status->status;

$mform = new manage_form();

/*
if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$internal_courseid);
    redirect($url);
} elseif ($fromform = $mform->get_data()) {

    //$mform->set_data($toform);
    $mform->display();
} elseif ($fromform = $mform->no_submit_button_pressed()) {
    //$url = new moodle_url('/blocks/coursefields/checkfields.php');
    //redirect($url);
} else {

    $mform->set_data($toform);
    $mform->display();
}
*/

$mform->set_data($toform);
$mform->display();
echo var_dump($course_status);
echo $OUTPUT->footer();

