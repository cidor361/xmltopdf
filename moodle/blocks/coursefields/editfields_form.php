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

class editfields_form extends moodleform {

    public function definition() {

        $context = null;
        $attr = array('size' => '100', 'maxlength' => '200');

        $mform = $this->_form;

        $mform->addElement('header', 'course_header', 'Свойства курса');
        $mform->addElement('static', 'require_field', 'Обратите внимание', 'Обязательны поля отмечены');
        $mform->addElement('static', 'empty_field', 'Обратите внимание', 'Не нужные поля оставить пустыми');
        $mform->addElement('text', 'title', get_string('title', 'block_coursefields'), $attr);
        $mform->addRule('title', null, 'required');
        $mform->addElement('text', 'image', get_string('image', 'block_coursefields'), $attr);
        $mform->setType('image', PARAM_TEXT);
        $mform->addElement('text', 'description', get_string('description', 'block_coursefields'), $attr);
        $mform->addRule('description', null, 'required');
        $mform->addElement('text', 'started_at', get_string('started_at', 'block_coursefields'), $attr);
        $mform->addElement('text', 'finished_at', get_string('finished_at', 'block_coursefields'), $attr);
//        $mform->addElement('text', 'competences', get_string('competences', 'block_coursefields'));
//        $mform->addElement('text', 'requirements', get_string('requirements', 'block_coursefields'));
        $mform->addElement('text', 'external_url', get_string('external_url', 'block_coursefields', $attr));
        $mform->addRule('external_url', null, 'required');
        $mform->addElement('text', 'direction', get_string('direction', 'block_coursefields'), $attr);
        $mform->addRule('direction', null, 'required');
        $mform->addElement('text', 'duration', get_string('duration', 'block_coursefields'), $attr);
        $mform->setType('duration', PARAM_TEXT);
        $mform->addRule('duration', null, 'required');
        $mform->addElement('text', 'lectures', get_string('lectures', 'block_coursefields'), $attr);
        $mform->setType('lectures', PARAM_TEXT);
        $mform->addElement('text', 'language', get_string('language', 'block_coursefields'), $attr);
        $mform->setType('language', PARAM_TEXT);
        $mform->addElement('advcheckbox', 'cert', '', get_string('cert', 'block_coursefields'));
        $mform->setDefault('cert', 0);
        $mform->addElement('text', 'results', get_string('results', 'block_coursefields'), $attr);
        $mform->setType('results', PARAM_TEXT);
        $mform->addElement('text', 'hours', get_string('hours', 'block_coursefields'), $attr);
        $mform->setType('hours', PARAM_TEXT);
        $mform->addElement('text', 'hours_per_week', get_string('hours_per_week', 'block_coursefields'), $attr);
        $mform->setType('hours_per_week', PARAM_TEXT);
        $mform->addElement('text', 'business_version', get_string('business_version', 'block_coursefields'), $attr);
        $mform->setType('business_version', PARAM_TEXT);
        $mform->addElement('text', 'promo_url', get_string('promo_url', 'block_coursefields'), $attr);
        $mform->setType('promo_url', PARAM_TEXT);
        $mform->addElement('text', 'promo_lang', get_string('promo_lang', 'block_coursefields'), $attr);
        $mform->setType('promo_lang', PARAM_TEXT);
        $mform->addElement('text', 'subtitles_lang', get_string('subtitles_lang', 'block_coursefields'), $attr);
        $mform->setType('subtitles_lang', PARAM_TEXT);
        $mform->addElement('text', 'estimation_tools', get_string('estimation_tools', 'block_coursefields'), $attr);
        $mform->setType('estimation_tools', PARAM_TEXT);
        $mform->addElement('text', 'proctoring_service', get_string('proctoring_service', 'block_coursefields'), $attr);
        $mform->setType('proctoring_service', PARAM_TEXT);

        $mform->addElement('header', 'teachers', get_string('teachers', 'block_coursefields'));
        $mform->addElement('text', 't_title', get_string('t_title', 'block_coursefields'), $attr);
        $mform->setType('t_title', PARAM_TEXT);
        $mform->addRule('t_title', null, 'required');
        $mform->addElement('text', 't_image', get_string('t_image', 'block_coursefields'), $attr);
        $mform->setType('t_image', PARAM_TEXT);
        $mform->addElement('text', 't_description', get_string('t_description', 'block_coursefields'), $attr);
        $mform->setType('t_description', PARAM_TEXT);

        $this->add_action_buttons($cancel = true, $submitlabel='Сохранить изменения');
        $mform->registerNoSubmitButton('continue');
        $otagsgrp = array();
        $otagsgrp[] =& $mform->createElement('submit', 'continue', 'Продолжить');
        $mform->addGroup($otagsgrp, 'otagsgrp', null, array(' '), false);
        $mform->setType('otagsadd', PARAM_NOTAGS);
    }

    function validation($data, $files) {
        return array();
    }

}
