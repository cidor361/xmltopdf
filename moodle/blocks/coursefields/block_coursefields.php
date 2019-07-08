<?php
require_once("list_form.php");

class block_coursefields extends block_base {

    public function init()
    {
        $this->title = get_string('course_fields', 'block_coursefields');
    }

    public function get_content()
    {
        if ($this->content != null) {
            return $this->content;
        }

        $id = optional_param('id', 0, PARAM_INT);
        $url = new moodle_url('/blocks/coursefields/list.php');
        $_SESSION['internal_courseid'] = $id;

        $this->content = new stdClass;
        $this->content->text = get_string('Description_plugin', 'block_coursefields');
        $this->content->footer = '<a href='.$url.'>Редактировать</a>';

        return $this->content;
    }
}