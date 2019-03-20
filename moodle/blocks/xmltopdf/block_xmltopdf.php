<?php
require_once("list_form.php");

class block_xmltopdf extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_xmltopdf');
    }
    
    public function get_content() {

        if ($this->content != null) {
            return $this->content;
        }

        $mform = new listform();
        $mform->add_simple_text('', get_string('banner', 'block_xmltopdf'), 'title');
        $mform->add_act_button();
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
