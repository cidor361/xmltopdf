<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
require_once('lib.php');
require_once($CFG->libdir.'/formslib.php');

class students_form extends moodleform {
	public $id;
	
	function definition() {
	    global $SESSION;
	    $data = $SESSION->first_data;

        $mform =& $this->_form;

        $mform->addElement('header', 'header_search', 'Ручной поиск пользователей');

        $mform->addElement('select', 'fac', 'Выберите факультет', $data->facultets);
        $mform->addElement('select', 'naprspec', 'Выберите специальность', $data->edu_specialites);
    	$mform->addElement('select', 'year', 'Выберите курс', $data->num_course);
    	$mform->addElement('select', 'stform', 'Выберите форму обучения', $data->edu_forms);
    	$mform->addElement('select', 'level', 'Выберите тип', $data->edu_level);

        $this->add_action_buttons($cancel = true, $submitlabel='Поиск');
    }

}
