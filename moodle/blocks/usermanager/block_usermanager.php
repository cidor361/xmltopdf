<?php
class block_usermanager extends block_base {

    public function init()
    {
        $this->title = 'usermanager';
    }

    public function get_content()
    {
        global $SESSION, $COURSE;
        if ($this->content != null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $url = new moodle_url('/blocks/usermanager/search_users.php');

        $SESSION->courseid = $COURSE->id;

        $this->content->text = 'Подписка студентов вручную';
        $this->content->footer = html_writer::link($url, 'Подписка по группам');

        return $this->content;
    }
}