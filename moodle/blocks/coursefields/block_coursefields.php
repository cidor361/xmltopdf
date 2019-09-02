<?php
require_once("list_form.php");

class block_coursefields extends block_base {

    public function init()
    {
        $this->title = get_string('course_fields', 'block_coursefields');
    }

    public function get_content()
    {
        global $COURSE, $USER;
        if ($this->content != null) {
            return $this->content;
        }

        $_SESSION['internal_courseid'] = $COURSE->id;;

        $this->content = new stdClass;
        $this->content->text = get_string('Description_plugin', 'block_coursefields');
        $url = new moodle_url('/blocks/coursefields/list.php');
        $this->content->footer = '<a href='.$url.'>Редактирование/Просмотр</a>';
        if (user_has_role_assignment($USER->id, 0) ) {
            $url = new moodle_url('/blocks/coursefields/portfolio.php');
            $this->content->footer .= '<br><a href='.$url.'>Портфолио</a>';
        }

        return $this->content;
    }
}