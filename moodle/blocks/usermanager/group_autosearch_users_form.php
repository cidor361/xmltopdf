<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page
}
require_once($CFG->libdir.'/formslib.php');

class group_autosearch_users_form extends moodleform {
    public $id;

    function definition() {
        global $SESSION;

        $disciplins = $SESSION->disciplins;

        $mform =& $this->_form;

        $mform->addElement('header', 'header_search', 'Найденные группы по вашему курсу');
        foreach ($disciplins as $disciplin) {
            $mform->addElement('advcheckbox', $disciplin->id, '',
                                $disciplin->speciality.' ('.$disciplin->step. ' '.$disciplin->st_form.') '.
                                $disciplin->year.' Год потока');
        }
        $this->add_checkbox_controller(1, null, null, 0);

        $this->add_action_buttons($cancel = true, $submitlabel = 'Выбрать группы');

    }

}
