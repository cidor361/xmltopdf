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
require_once('editfields_form.php');
require_login();


$PAGE->set_url('/blocks/coursefields/editfields.php');
//$PAGE->set_pagelayout('standart');
$PAGE->set_title('Поля курса');
//$PAGE->set_heading('Поля курса');
//$PAGE->set_context(context_course:instance($SESSION->courseid));

$exist = $DB->record_exists('block_coursefields', array('internal_courseid' => $internal_courseid));
if ($exist) {
    $Object = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid));
}


$mform = new editfields_form();
if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$COURSE->id);
    redirect($url); //TODO: get courseid!
} elseif ($fromform = $mform->get_data()) {

} elseif ($fromform = $mform->no_submit_button_pressed()) {
    $url = new moodle_url('/blocks/coursefields/checkfields.php');
    redirect($url);
} else {

    $mform->set_data($toform);
    $mform->display();
}

echo $OUTPUT->header();

echo $OUTPUT->footer();
