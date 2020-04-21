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
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('header', 'course_header', 'Свойства курса');
        $mform->addElement('static', 'title', get_string('title', 'block_coursefields'), $Object->title);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'image', get_string('image', 'block_coursefields'), $attributes);
        $mform->setType('image', PARAM_TEXT);
        $mform->setDefault('image', $Object->image);
        $mform->addElement('static', $id, $title, $text);
        $mform->addElement('static', 'description', get_string('description', 'block_coursefields'), $Object->description);
        $mform->addElement('static', 'started_at', get_string('started_at', 'block_coursefields'), $Object->started_at);
        $mform->addElement('static', 'finished_at', get_string('finished_at', 'block_coursefields'), $Object->finished_at);
        $mform->addElement('static', 'competences', get_string('competences', 'block_coursefields'), $Object->competences);
        $mform->addElement('static', 'requirements', get_string('requirements', 'block_coursefields'), $Object->requirements);
        $mform->addElement('static', 'external_url', get_string('external_url', 'block_coursefields'), $Object->external_url);
        $attributes = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=>$maxfiles, 'maxbytes'=>$maxbytes, 'context'=>$context);
        $mform->addElement('editor', 'direction', get_string('direction', 'block_coursefields'), null, $attributes)->setValue(array('text' => $Object->direction->text));
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'duration', get_string('duration', 'block_coursefields'), $attributes);
        $mform->setType('duration', PARAM_TEXT);
        $mform->setDefault('duration', $Object->duration);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'lectures', get_string('lectures', 'block_coursefields'), $attributes);
        $mform->setType('lectures', PARAM_TEXT);
        $mform->setDefault('lectures', $Object->lectures);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'language', get_string('language', 'block_coursefields'), $attributes);
        $mform->setType('language', PARAM_TEXT);
        $mform->setDefault('language', $Object->language);
        $mform->addElement('advcheckbox', 'cert', get_string('cert', 'block_coursefields'));
        $mform->setDefault('cert', 0);
        $attributes = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=>$maxfiles, 'maxbytes'=>$maxbytes, 'context'=>$context);
        $mform->addElement('editor', 'results', get_string('results', 'block_coursefields'), null, $attributes)->setValue(array('text' => $Object->results));
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'hours', get_string('hours', 'block_coursefields'), $attributes);
        $mform->setType('hours', PARAM_TEXT);
        $mform->setDefault('hours', $Object->hours);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'hours_per_week', get_string('hours_per_week', 'block_coursefields'), $attributes);
        $mform->setType('hours_per_week', PARAM_TEXT);
        $mform->setDefault('hours_per_week', $Object->hours_per_week);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'business_version', get_string('business_version', 'block_coursefields'), $attributes);
        $mform->setType('business_version', PARAM_TEXT);
        $mform->setDefault('business_version', $Object->business_version);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'promo_url', get_string('promo_url', 'block_coursefields'), $attributes);
        $mform->setType('promo_url', PARAM_TEXT);
        $mform->setDefault('promo_url', $Object->promo_url);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'promo_lang', get_string('promo_lang', 'block_coursefields'), $attributes);
        $mform->setType('promo_lang', PARAM_TEXT);
        $mform->setDefault('promo_lang', $Object->promo_lang);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'subtitles_lang', get_string('subtitles_lang', 'block_coursefields'), $attributes);
        $mform->setType('subtitles_lang', PARAM_TEXT);
        $mform->setDefault('subtitles_lang', $Object->subtitles_lang);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'estimation_tools', get_string('estimation_tools', 'block_coursefields'), $attributes);
        $mform->setType('estimation_tools', PARAM_TEXT);
        $mform->setDefault('estimation_tools', $Object->estimation_tools);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 'proctoring_service', get_string('proctoring_service', 'block_coursefields'), $attributes);
        $mform->setType('proctoring_service', PARAM_TEXT);
        $mform->setDefault('proctoring_service', $Object->proctoring_service);

        $mform->addElement('header', 'teachers', get_string('teachers', 'block_coursefields'));
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 't_title', get_string('t_title', 'block_coursefields'), $attributes);
        $mform->setType('t_title', PARAM_TEXT);
        $mform->setDefault('t_title', $Object->teachers[0]->display_name);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 't_image', get_string('t_image', 'block_coursefields'), $attributes);
        $mform->setType('t_image', PARAM_TEXT);
        $mform->setDefault('t_image', $Object->teachers[0]->image);
        $attributes = array('size' => '50', 'maxlength' => '100');
        $mform->addElement('text', 't_description', get_string('t_description', 'block_coursefields'), $attributes);
        $mform->setType('t_description', PARAM_TEXT);
        $mform->setDefault('t_description', $Object->teachers[0]->description);
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
