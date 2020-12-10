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

//require_once(__DIR__.'lib.php');

class block_coursefields extends block_base {

    public function init() {
        $this->title = get_string('course_fields', 'block_coursefields');
    }

    public function get_content() {
        global $COURSE, $SESSION, $USER;

        //$context = context_course::instance($COURSE->id);
        $SESSION->courseid = $COURSE->id;
        $SESSION->context = $this->context;

        if ($this->content != null) {
            return $this->content;
        }

        if (!has_capability('block/coursefield:viewblock', $this->context)) {
            return null;
        }

        $this->content = new stdClass;
        $this->content->text = get_string('Description_plugin', 'block_coursefields');
        $url = new moodle_url('/blocks/coursefields/editfields.php');
        $this->content->footer = html_writer::link($url, 'Редактирование/Просмотр полей').'</br>';
        if (has_capability('block/coursefield:manage_data', $this->context)) {
            $url = new moodle_url('/blocks/coursefields/manage.php');
            $this->content->footer .= html_writer::link($url, 'Уравление отправкой').'</br>';
        }
        if (is_primary_admin($USER->id)) {
            $url = new moodle_url('/blocks/coursefields/admin.php');
            $this->content->footer .= html_writer::link($url, 'Администрирование');
        }

    }
}
