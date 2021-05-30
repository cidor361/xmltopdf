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

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

class manage_form extends moodleform
{

    public function definition()
    {

        $context = null;
        $attr = array('size' => '100', 'maxlength' => '200');

        $mform = $this->_form;
/*
        $mform->addElement('text', 'login', get_string('login', 'block_coursefields'), $attr);
        $mform->setType('login', PARAM_TEXT);
        $mform->addElement('password', 'password', get_string('password', 'block_coursefields'), $attr);
*/
        $mform->addElement('header', 'information_header', 'Информация курса');
        $mform->addElement('static', 'external_courseid', 'Внешний ID курса');
        $mform->addElement('static', 'get_grade_status_course', 'Статус оценки курса');

        $mform->addElement('header', 'in_progress', 'В разработке');
        $mform->addElement('static', 'num_of_users', 'Количество студентов, подписанных на курс');

/*
        $this->add_action_buttons($cancel = true, $submitlabel='Submittion button');
        $mform->registerNoSubmitButton('update');
        $otagsgrp = array();
        $otagsgrp[] =& $mform->createElement('submit', 'update', 'Продолжить');
        $mform->addGroup($otagsgrp, 'otagsgrp', null, array(' '), false);
        $mform->setType('otagsadd', PARAM_NOTAGS);
*/
    }

    function validation($data, $files)
    {
        return array();
    }

}