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
 * @copyright  2008 Kim Bloggs
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('admin_form.php');
require_once('lib.php');
require_once('info_test.php');

$internal_courseid = $SESSION->internal_courseid;
//$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);
$PAGE->set_url('/blocks/coursefields/admin.php');
//$PAGE->set_pagelayout('standart');
$PAGE->set_title('Администрирование');
$PAGE->set_heading('Администрирование');
//$PAGE->set_context(context_course::instance($internal_courseid));
require_login($internal_courseid);

$mform = new admin_form();

$data = new stdClass();
$data->number_of_records = $DB->count_records('block_coursefields');

$mform->set_data($data);

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
