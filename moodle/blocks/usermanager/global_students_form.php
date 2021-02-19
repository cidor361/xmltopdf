<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
require_once('lib.php');
require_once($CFG->libdir.'/formslib.php');

class students_form extends moodleform {
	public $id;
	
	function definition() {
        $mform =& $this->_form;
        
        //Заголовок

        $ids = get_extra_field_ids();
        $facultets = get_facultets($ids);
    	$num_course = get_num_course($ids);
        usort($num_course);
    	$edu_forms = get_edu_forms($ids);
    	$edu_level = get_edu_level($ids);
    	$edu_specialites = get_edu_specialites($ids);
        $mform->addElement('select', 'fac', 'Выберите факультет', $facultets);
        $mform->addElement('select', 'naprspec', 'Выберите специальность', $edu_specialites);
    	$mform->addElement('select', 'year', 'Выберите курс', $num_course);
    	$mform->addElement('select', 'stform', 'Выберите форму обучения', $edu_forms);
    	$mform->addElement('select', 'level', 'Выберите тип', $edu_level);


        $this->add_action_buttons($cancel = true, $submitlabel='Поиск');
	}
}
/*
class students_show_form extends moodleform {
	public $id;
	
	function definition() {
        $mform =& $this->_form;
        
        //Заголовок
        
        //$field_ids = get_extra_field_ids();
        $mform->addElement('select', 'fac', 'Выберите факультет', '');
        //$years = get_num_course($field_ids);
        
        $this->add_action_buttons();
	}
}
*/