<?php
require_once("{$CFG->libdir}/formslib.php");

class listform extends moodleform {
    private $mform;

    function definition() {
        $this->mform =& $this->_form;
    }

    function add_filepicker() {
        $this->mform->addElement('filepicker', 'userfile', 'Please pick xml file');
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
        $num = uniqid();
        $this->mform->addElement('date_selector', $num, $title, array('optional' => true));
        $this->mform->setAdvanced('optional');
        $defaulttime = make_timestamp($year, $month, $day);
        $this->mform->setDefault('requesteddate',  $defaulttime);
    }

    function add_textfield($title, $text) {
        $attributes = array('size' => '50', 'maxlength' => '100');
        $num = uniqid();
        $this->mform->addElement('text', $num, $title, $attributes);
        $this->mform->setType($num, PARAM_TEXT);
        $this->mform->setDefault($num, $text);
        //TODO: Установка текста!
    }

    function add_simple_text($title, $text) {
        $this->mform->addElement('static', uniqid(), $title, $text);
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

    function add_link($title, $link, $text) {
        $this->mform->addElement('static', 'staticlink', $title, '<a href='.$link.'>'.$text.'</a>');
    }
}