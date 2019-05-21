<?php
require_once("{$CFG->libdir}/formslib.php");

class listPortfForm extends moodleform {
    private $mform;

    function definition() {
        $this->mform =& $this->_form;
    }

    function add_filepicker() {
        $this->mform->addElement('filepicker', 'userfile', 'Прикрепите XML файл');
        $this->mform->addRule('userfile', null, 'required');
//        $this->mform->disabledIf('userfile', 'url', 'noteq', '');
    }

    function add_filemanager($title) {
        $this->mform->addElement('filemanager', 'attachments', $titlee, null,
            array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 50,
                'accepted_types' => array('document'), 'return_types'=> FILE_INTERNAL | FILE_EXTERNAL));
    }

    function add_header($title) {
        $this->mform->addElement('header','displayinfo', $title);
    }

    function add_data_selector($title, $year, $month, $day) {
        $this->mform->addElement('date_selector', 'assesstimefinish', $title, array('optional' => true));
        $this->mform->setAdvanced('optional');
        $defaulttime = make_timestamp($year, $month, $day);
        $this->mform->setDefault('requesteddate',  $defaulttime);
    }

    function add_textfield($title) {
        $attributes = array('size' => '50', 'maxlength' => '100');
        $this->mform->addElement('text', 'description', $title, $attributes);
        $this->mform->setType('description', PARAM_TEXT);
        $this->mform->setDefault('text', 'qqqqqq');
        //TODO: Установка текста!
    }

    function add_simple_text($title, $text) {
        $this->mform->addElement('static', 'description', $title, $text);
    }

    function add_email($title, $text) {
        $this->mform->addElement('text', 'email', $title);
        $this->mform->setType('email', PARAM_NOTAGS);
        $this->mform->setDefault('email', $text);
    }

    function add_checkbox() {
        $this->mform->addElement('advcheckbox', "config_checkbox", $repository->name);
        $this->mform->setType("config_checkbox", PARAM_BOOL);
    }

    function add_act_button() {
        $this->add_action_buttons();
    }

    function add_selectwithlink() {
        $options = array();
        $this->mform->addElement('selectwithlink', 'scaleid', get_string('scale'), $options, null,
            array('link' => $CFG->wwwroot.'/grade/edit/scale/edit.php?courseid='.$COURSE->id, 'label' => get_string('scalescustomcreate')));
    }

    function add_link($title, $link) {
        $this->mform->addElement('static', 'staticlink', $title, $link);
    }
    function add_text_editor($title, $text, $id) {
        $textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=>$maxfiles,
            'maxbytes'=>$maxbytes, 'context'=>$context);
        $this->mform->addElement('editor', $id, $title, null, $textfieldoptions)->setValue(array('text' => $text));
    }

    function reset() {
        //TODO: доделать!
        $this->mform->reset();
    }
}