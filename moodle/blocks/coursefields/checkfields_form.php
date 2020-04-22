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
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('header', 'course', 'Свойства курса');
        $mform->addElement('static', 'title', get_string('title', 'block_coursefields'), $Object->title);
        $mform->addElement('static', 'image', get_string('image', 'block_coursefields'), $Object->image);
        $mform->addElement('static', 'description', get_string('description', 'block_coursefields'), $Object->description);
        $mform->addElement('static', 'started_at', get_string('started_at', 'block_coursefields'), $Object->started_at);
        $mform->addElement('static', 'finished_at', get_string('finished_at', 'block_coursefields'), $Object->finished_at);
        $mform->addElement('static', 'competences', get_string('competences', 'block_coursefields'), $Object->competences);
//        $mform->addElement('static', 'requirements', get_string('requirements', 'block_coursefields'), $Object->requirements);
        $mform->addElement('static', 'external_url', get_string('external_url', 'block_coursefields'), $Object->external_url);
        $mform->addElement('static', 'direction', get_string('direction', 'block_coursefields'), $Object->direction->text);
//        $mform->addElement('static', 'institution', get_string('institution', 'block_coursefields'), $Object->institution);
        $mform->addElement('static', 'duration', get_string('duration', 'block_coursefields'), $Object->duration);
        $mform->addElement('static', 'lectures', get_string('lectures', 'block_coursefields'), $Object->lectures);
        $mform->addElement('static', 'language', get_string('language', 'block_coursefields'), $Object->language);
        $mform->addElement('static', 'cert', get_string('cert', 'block_coursefields'), $Object->cert);
//        $mform->addElement('static', 'visitors', get_string('visitors', 'block_coursefields'), $Object->visitors);
        $mform->addElement('static', 'results', get_string('results', 'block_coursefields'), $Object->results);
//        $mform->addElement('static', 'accreditated', get_string('accreditated', 'block_coursefields'), $Object->accreditated);
        $mform->addElement('static', 'hours', get_string('hours', 'block_coursefields'), $Object->hours);
        $mform->addElement('static', 'hours_per_week', get_string('hours_per_week', 'block_coursefields'), $Object->hours_per_week);
        $mform->addElement('static', 'business_version', get_string('business_version', 'block_coursefields'), $Object->business_version);
        $mform->addElement('static', 'promo_url', get_string('promo_url', 'block_coursefields'), $Object->promo_url);
        $mform->addElement('static', 'promo_lang', get_string('promo_lang', 'block_coursefields'), $Object->promo_lang);
        $mform->addElement('static', 'subtitles_lang', get_string('subtitles_lang', 'block_coursefields'), $Object->subtitles_lang);
//        $mform->addElement('static', 'estimation_tools', get_string('estimation_tools', 'block_coursefields'), $Object->estimation_tools);
        $mform->addElement('static', 'proctoring_service', get_string('proctoring_service', 'block_coursefields'), $Object->proctoring_service);
//        $mform->addElement('static', 'sessionid', get_string('sessionid', 'block_coursefields'), $Object->sessionid);
        $mform->addElement('header', 'teachers', 'Преподаватели');
        $mform->addElement('static', 't_title', get_string('t_title', 'block_coursefields'), $Object->teachers[0]->display_name);
        $mform->addElement('static', 't_image', get_string('t_image', 'block_coursefields'), $Object->teachers[0]->image);
        $mform->addElement('static', 't_description', get_string('t_description', 'block_coursefields'), $Object->teachers[0]->description);
        $mform->addElement('header', 'coursetransfer', 'Информация о перезачётах');
        $mform->addElement('static', 'institution_id', get_string('institution_id', 'block_coursefields'), $Object->transfers->courseTransfer[0]->institution_id);
        $mform->addElement('static', 'direction_id', get_string('direction_id', 'block_coursefields'), $Object->transfers->courseTransfer[0]->direction_id);
        $this->add_action_buttons($cancel = true, $submitlabel='Отправить');

    }

    function validation($data, $files) {
        return array();
    }

}
