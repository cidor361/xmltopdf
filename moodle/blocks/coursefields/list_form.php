<?php
defined('MOODLE_INTERNAL') || die();

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

    function add_header($title, $id) {
        $this->mform->addElement('header', $id, $title);
    }

    function add_data_selector($title, $year, $month, $day, $id) {
        $this->mform->addElement('date_selector', $id, $title, array('optional' => true));
        $this->mform->setAdvanced('optional');
        $defaulttime = make_timestamp($year, $month, $day);
        $this->mform->setDefault($id, $defaulttime);
    }

    function add_textfield($title, $text, $id, $require = null) {
        $attributes = array('size' => '50', 'maxlength' => '100');
        $this->mform->addElement('text', $id, $title, $attributes);
        $this->mform->setType($id, PARAM_TEXT);
        $this->mform->setDefault($id, $text);
        if ($require != null) {
            $this->mform->addRule($id, 'required', 'required');
        }
    }

    function add_simple_text($title, $text, $id) {
        $this->mform->addElement('static', $id, $title, $text);
    }

    function add_email($title, $text) {
        $this->mform->addElement('text', 'email', $title);
        $this->mform->setType('email', PARAM_NOTAGS);
        $this->mform->setDefault('email', $text);
    }

    function add_checkbox($title) {
        $this->mform->addElement('advcheckbox', 'ratingtime', $title);
//        $this->mform->setType("config_checkbox", PARAM_BOOL);
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
    function add_text_area($title, $text, $id) {
        $this->mform->addElement('textarea', $id, $title, 'wrap = "virtual" rows = "20" cols = "50"');
        $this->mform->setDefault($id, $text);
    }
    function add_text_editor($title, $text, $id, $require = null) {
        $textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=>$maxfiles, 'maxbytes'=>$maxbytes, 'context'=>$context);
        $this->mform->addElement('editor', $id, $title, null, $textfieldoptions)->setValue(array('text' => $text));
        if ($require != null) {
            $this->mform->addRule($id, 'required', 'required');
        }
    }
}