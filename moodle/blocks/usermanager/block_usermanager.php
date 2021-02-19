<?php
class block_usermanager extends block_base {

    public function init()
    {
        $this->title = 'usermanager';
    }

    public function get_content()
    {
        if ($this->content != null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $url = new moodle_url('/blocks/usermanager/global_students.php');

        $this->content->text = 'The content of our SimpleHTML block!';
        $this->content->footer = html_writer::link($url, 'Подписка по группам');

        return $this->content;
    }
}