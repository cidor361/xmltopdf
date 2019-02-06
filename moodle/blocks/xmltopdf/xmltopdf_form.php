<?php
require_once("$CFG->libdir/formslib.php");
 
class xmltopdf_form extends moodleform {
    public function definition() {
//        global $CFG;

        $mform = $this->_form;
        $mform->addElement('static', 'description', '', 'Этот плагин создан для конвертирования резюме в xml формате в др');
        $this->add_action_buttons();
    }
}