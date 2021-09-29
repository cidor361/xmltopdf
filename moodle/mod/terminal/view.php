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
 * @package    mod_terminal
 * @category   mod
 * @copyright  2021 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // terminal instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('terminal', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $terminal   = $DB->get_record('terminal', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $terminal   = $DB->get_record('terminal', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $terminal->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('terminal', $terminal->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$PAGE->set_url('/mod/terminal/view.php', array('id' => $cm->id));
$PAGE->set_title($terminal->name);
$PAGE->set_heading($course->shortname);
//$PAGE->set_button(update_module_button($cm->id, $course->id, get_string('pluginname', 'terminal')));  //update_module_button has been deprecated!

$context = context_course::instance($course->id);
$roles = get_user_roles($context, $USER->id);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('terminal', 'yourterminal').$cm->name);



echo $OUTPUT->footer();
