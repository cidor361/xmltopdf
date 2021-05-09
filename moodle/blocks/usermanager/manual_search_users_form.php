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

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once('lib.php');
require_once($CFG->libdir.'/formslib.php');

class students_form extends moodleform {
	public $id;
	
	function definition() {
        $ids = get_user_field_ids();
        $data = new stdClass();
        $data->facultets = get_facultet_names($ids);
        $data->num_course = get_num_course_name($ids);
        $data->edu_forms = get_edu_forms_name($ids);
        $data->edu_level = get_edu_level_name($ids);
        $data->edu_specialites = get_edu_specialites_name($ids);

        $mform =& $this->_form;

        $mform->addElement('header', 'header_search', get_string('manual_search_students', 'block_usermanager'));

        $mform->addElement('select', 'fac', get_string('choose_faculty', 'block_usermanager'),
                            $data->facultets);
        $mform->addElement('select', 'naprspec', get_string('choose_edu_specialites', 'block_usermanager'),
                            $data->edu_specialites);
    	$mform->addElement('select', 'year', get_string('choose_course', 'block_usermanager'),
                            $data->num_course);
    	$mform->addElement('select', 'stform', get_string('choose_edu_forms', 'block_usermanager'),
                            $data->edu_forms);
    	$mform->addElement('select', 'level', get_string('choose_edu_level', 'block_usermanager'),
                            $data->edu_level);

        $this->add_action_buttons($cancel = true, $submitlabel='Поиск');
    }

}
