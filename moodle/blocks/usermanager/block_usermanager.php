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

        $SESSION->courseid = $COURSE->id;

        $this->content->text = 'Подписка студентов вручную';
        $url = new moodle_url('/blocks/usermanager/manual_search_users.php');
        $this->content->footer = html_writer::link($url, 'Ручная подписка пользователей');
        $this->content->footer .= '</br>';
        $url = new moodle_url('/blocks/usermanager/group_autosearch_users.php');
        $this->content->footer .= html_writer::link($url, 'Автоматическая подписка по группам');

        return $this->content;
    }
}