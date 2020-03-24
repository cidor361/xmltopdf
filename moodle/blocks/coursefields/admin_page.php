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

require(__DIR__.'../../config.php');
require_once(__DIR__.'lib.php');
require_once(__DIR__.'info.php');
require_login($internal_courseid);

$internal_courseid = $SESSION->internal_courseid;
$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);
$PAGE->set_url('/blocks/coursefields/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('Мониторинг');
$PAGE->set_heading('Мониторинг');
$PAGE->set_context(context_course::instance($internal_courseid));

$number_of_records = $DB->count_records('block_coursefields');

$mform = $this->_form;
$mform->addElement('static', 'number_of_records', 'Количество записей в БД', $number_of_records);

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
