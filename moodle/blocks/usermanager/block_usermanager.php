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

class block_usermanager extends block_base {

    public function init()
    {
        $this->title = get_string('enrol_user_title', 'block_usermanager');
    }

    public function get_content()
    {
        global $SESSION, $COURSE;
        if ($this->content != null) {
            return $this->content;
        }

        $this->content = new stdClass;

        $SESSION->courseid = $COURSE->id;

        $this->content->text = get_string('type_of_enrol', 'block_usermanager');
        $url = new moodle_url('/blocks/usermanager/manual_search_users.php');
        $this->content->footer = html_writer::link($url, get_string('manual_enrol_link', 'block_usermanager'));
        $this->content->footer .= '</br>';
        $url = new moodle_url('/blocks/usermanager/group_autosearch_users.php');
        $this->content->footer .= html_writer::link($url, get_string('auto_enrol_link', 'block_usermanager'));

        return $this->content;
    }
}
