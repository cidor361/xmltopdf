<?php
require_once("xmltopdf_form.php");

class block_xmltopdf extends block_base {

    public function init() {
        $this->title = get_string('course_fields', 'block_xmltopdf');
    }
    
    public function get_content() {
//        global $CFG;

        if ($this->content != null) {
            return $this->content;
        }

        $mform = new xmltopdf_form();
        $this->content = new stdClass;

        if ($mform->is_cancelled()) {
        } else if ($fromform = $mform->get_data()) {
            $url = new moodle_url('/blocks/xmltopdf/list.php');
            redirect($url);
        } else {}
        $this->content->text = $mform->render();
        return $this->content;
        $mform->display();

    }
}
