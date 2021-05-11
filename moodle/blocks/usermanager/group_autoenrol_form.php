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
require_once($CFG->libdir . '/formslib.php');

class group_autoenrol_form extends moodleform
{
    public $id;

    function definition()
    {
        global $SESSION;

        $mform =& $this->_form;

        $groups_of_users_disciplin = $SESSION->groups_of_users;
        foreach ($groups_of_users_disciplin as $disciplin_num=>$groups_of_users) {
            if ($groups_of_users != null) {
                foreach ($groups_of_users as $group_num => $group) {
                    if ($group != null) {
                        $id = $disciplin_num.'_'.$group_num;
                        $mform->addElement('header', $id.'-header', 'Группа №' . $group_num);
                        $mform->addElement('advcheckbox', $id,
                                            '', get_string('select_group', 'block_usermanager') . $group_num);
                        $mform->setExpanded($id.'-header', false);
                        foreach ($group as $user) {
                            if ($user->enrolled) {
                                $enrolled = get_string('enrolled', 'block_usermanager');
                            } else {
                                $enrolled = '';
                            }
                            $mform->addElement('static', $user->id, $enrolled, $user->firstname . ' ' . $user->lastname);
                        }
                    }
                }

                $this->add_action_buttons($cancel = true, $submitlabel = get_string('enroll_group', 'block_usermanager'));
            }
        }
    }

}

