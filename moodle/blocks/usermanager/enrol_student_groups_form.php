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

require_once($CFG->libdir.'/formslib.php');

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class group_search_user_groups_form extends moodleform
{
    public $id;

    function definition()
    {
        global $CFG, $PAGE;

        $courseid = $PAGE->course->id;
        $disciplins = $this->_customdata['disciplins'];

        $mform =& $this->_form;

        $mform->addElement('hidden', 'courseid', $this->_customdata['courseid']);
        $mform->addElement('html', '<h2>'.get_string('finded_connects_on_course', 'block_usermanager').'</h2>');
        foreach ($disciplins as $disciplin) {
            $mform->addElement('html', '<h4>'.$disciplin->speciality_code.' '.$disciplin->speciality.' (' .
                $disciplin->step.' '.$disciplin->st_form.') '.$disciplin->year.' ' .
                get_string('course_year', 'block_usermanager').'</h4>');
        }

        $mform->addElement('html', '<br><h2>'.get_string('finded_academic_group_on_course', 'block_usermanager').'</h2>');
        $this->add_checkbox_controller(1, null, null, 0);
        $groups_of_users_per_disciplin = $this->_customdata['groups_of_users_per_disciplin'];
        $extra_groups_of_users_per_disciplin = $this->_customdata['extra_groups_of_users_per_disciplin'];
        foreach ($groups_of_users_per_disciplin as $disciplin_num=>$groups_of_users) {
            if ($groups_of_users != null) {
                foreach ($groups_of_users as $group_num => $group) {
                    $moodle_group_name = '';
                    $faculty = explode(' ', $disciplins->{$disciplin_num}->faculty);
                    $moodle_group_name .= $faculty[0].' ';
                    $moodle_group_name .= $disciplins->{$disciplin_num}->speciality.' ';
                    $moodle_group_name .= $disciplins->{$disciplin_num}->step;
                    $moodle_group_name .= ' '.$group_num.' группа ';
                    $moodle_group_name .= $disciplins->{$disciplin_num}->year.'г. ';
                    $moodle_group_name .= $disciplins->{$disciplin_num}->st_form;

                    if ($group != null) {
                        $id = $disciplin_num.'_'.$group_num;
                        $mform->addElement('advcheckbox', $id, $moodle_group_name, ' ', array('group' => 1));
                        $i = 1;
                        $list_of_user = '';
                        foreach ($group as $user) {
                            if ($user->enrolled) {
                                $enrolled = get_string('enrolled', 'block_usermanager');
                            } else {
                                $enrolled = '';
                            }
                            $list_of_user .= $i.'. '.$user->lastname.' '.$user->firstname.' '.$enrolled.'</br>';
                            $i++;
                        }
                        $mform->addElement('html', '<details><summary>Список студентов '.$group_num.' группы</summary>'.$list_of_user.'</details></br>');
                    }
                }

            }
        }

        $groups_of_users_disciplin = $this->_customdata['extra_groups_of_users_per_disciplin'];
        if ($groups_of_users_disciplin != null) {
            $mform->addElement('header', 'extra_groups', get_string('extra_groups', 'block_usermanager'));
            $mform->addElement('static', 'extra_groups_notify', get_string('extra_groups_notify', 'block_usermanager'));
            foreach ($extra_groups_of_users_per_disciplin as $disciplin_num => $groups_of_users) {
                if ($groups_of_users != null) {
                    foreach ($groups_of_users as $group_num => $group) {
                        $moodle_group_name = '';
                        $moodle_group_name .= $disciplins->{$disciplin_num}->faculty.' ';
                        $moodle_group_name .= $disciplins->{$disciplin_num}->speciality;
                        $moodle_group_name .= ' ('.$disciplins->{$disciplin_num}->step.', ';
                        $moodle_group_name .= $disciplins->{$disciplin_num}->st_form;
                        $moodle_group_name .= ' '.$group_num.' группа) ';
                        $moodle_group_name .= $disciplins->{$disciplin_num}->year.' года потока';
                        if ($group != null) {
                            $id = $disciplin_num.'_'.$group_num;
                            $mform->addElement('advcheckbox', $id.'_extra', $moodle_group_name, ' ', array('group' => 2));
                            $i = 1;
                            $list_of_user = '';
                            foreach ($group as $user) {
                                if ($user->enrolled) {
                                    $enrolled = get_string('enrolled', 'block_usermanager');
                                } else {
                                    $enrolled = '';
                                }
                                $list_of_user .= $i.'. '.$user->lastname.' '.$user->firstname.' '.$enrolled.'</br>';
                                $i++;
                            }
                            $mform->addElement('html', '<details><summary>Список студентов '.$group_num.' группы</summary>'.$list_of_user.'</details></br>');
                        }
                    }

                }
            }
        }
        $mform->setExpanded('extra_groups', false);
        $this->add_action_buttons($cancel = false, $submitlabel = get_string('enroll_group', 'block_usermanager'));
    }
}

/*
6563
*/
