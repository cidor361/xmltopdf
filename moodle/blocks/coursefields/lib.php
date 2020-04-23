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

defined('MOODLE_INTERNAL') || die();

function get_course_info($course, $USER, $info=null) {
    $toform = new stdClass();
    $toform->title = $course->fullname;
    $toform->started_at = gmdate("Y-m-d", (int)$course->startdate);
    $toform->finished_at = gmdate("Y-m-d", (int)$course->enddate);
    $toform->description = strip_html_tags($course->summary);
    $toform->external_url = $info['courselink'] . $course->id;
    $toform->institution = $info['institution'];
    $toform->language = 'ru';
    $toform->teachers = array();
    $toform->teachers[0]->display_name = $USER->firstname . ' ' . $USER->lastname;
    return $toform;
}

function strip_html_tags($string)
{
    $string = strip_tags($string, '');
    $string = str_replace("\n", ' ', $string);
    $string = str_replace("\r", '', $string);
    return $string;
}
