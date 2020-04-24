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

class checkfields_form extends moodleform {

    public function definition() {

        $maxbytes = 500;
        $maxfiles = 0;
        $context = null;
        $attr = array('size' => '100', 'maxlength' => '200');


        $mform = $this->_form;

        $mform->addElement('header', 'course_header', 'Свойства курса');
        $mform->addElement('static', 'title', get_string('title', 'block_coursefields'));
        $mform->addElement('text', 'image', get_string('image', 'block_coursefields'), $attr)->freeze();
//        $mform->setDefault('image', $Object->image);
        $mform->addElement('static', 'description', get_string('description', 'block_coursefields'));
        $mform->addElement('static', 'started_at', get_string('started_at', 'block_coursefields'));
        $mform->addElement('static', 'finished_at', get_string('finished_at', 'block_coursefields'));
//        $mform->addElement('text', 'competences', get_string('competences', 'block_coursefields'));
//        $mform->addElement('text', 'requirements', get_string('requirements', 'block_coursefields'));
        $mform->addElement('static', 'external_url', get_string('external_url', 'block_coursefields'));
        $mform->addElement('text', 'direction', get_string('direction', 'block_coursefields'), $attr)->freeze();
        $mform->addElement('text', 'duration', get_string('duration', 'block_coursefields'), $attr)->freeze();
        $mform->setType('duration', PARAM_TEXT);
        $mform->addElement('text', 'lectures', get_string('lectures', 'block_coursefields'), $attr)->freeze();
        $mform->setType('lectures', PARAM_TEXT);
        $mform->addElement('text', 'language', get_string('language', 'block_coursefields'), $attr)->freeze();
        $mform->setType('language', PARAM_TEXT);
        $mform->addElement('advcheckbox', 'cert', '', get_string('cert', 'block_coursefields'))->freeze();
        $mform->setDefault('cert', 0);
        $mform->addElement('text', 'results', get_string('results', 'block_coursefields'), $attr)->freeze();
        $mform->setType('results', PARAM_TEXT);
        $mform->addElement('text', 'hours', get_string('hours', 'block_coursefields'), $attr)->freeze();
        $mform->setType('hours', PARAM_TEXT);
        $mform->addElement('text', 'hours_per_week', get_string('hours_per_week', 'block_coursefields'), $attr)->freeze();
        $mform->setType('hours_per_week', PARAM_TEXT);
        $mform->addElement('text', 'business_version', get_string('business_version', 'block_coursefields'), $attr)->freeze();
        $mform->setType('business_version', PARAM_TEXT);
        $mform->addElement('text', 'promo_url', get_string('promo_url', 'block_coursefields'), $attr)->freeze();
        $mform->setType('promo_url', PARAM_TEXT);
        $mform->addElement('text', 'promo_lang', get_string('promo_lang', 'block_coursefields'), $attr)->freeze();
        $mform->setType('promo_lang', PARAM_TEXT);
        $mform->addElement('text', 'subtitles_lang', get_string('subtitles_lang', 'block_coursefields'), $attr)->freeze();
        $mform->setType('subtitles_lang', PARAM_TEXT);
        $mform->addElement('text', 'estimation_tools', get_string('estimation_tools', 'block_coursefields'), $attr)->freeze();
        $mform->setType('estimation_tools', PARAM_TEXT);
        $mform->addElement('text', 'proctoring_service', get_string('proctoring_service', 'block_coursefields'), $attr)->freeze();
        $mform->setType('proctoring_service', PARAM_TEXT);

        $mform->addElement('header', 'teachers', get_string('teachers', 'block_coursefields'));
        $mform->addElement('text', 't_title', get_string('t_title', 'block_coursefields'), $attr)->freeze();
        $mform->setType('t_title', PARAM_TEXT);
        $mform->addElement('text', 't_image', get_string('t_image', 'block_coursefields'), $attr)->freeze();
        $mform->setType('t_image', PARAM_TEXT);
        $mform->addElement('text', 't_description', get_string('t_description', 'block_coursefields'), $attr)->freeze();
        $mform->setType('t_description', PARAM_TEXT);

        $this->add_action_buttons($cancel = true, $submitlabel='Отправить');




    }

    function validation($data, $files) {
        return array();
    }

}
