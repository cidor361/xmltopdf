<?php
class block_course_statistic extends block_base {

    public function init()
    {
        $this->title = get_string('pluginname', 'block_course_statistic');
    }

    public function get_content()
    {
        if ($this->content != null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = get_string('description', 'block_course_statistic');
        $url = new moodle_url('/blocks/course_statistic/statistic.php');
        $this->content->footer = html_writer::link($url,
            get_string('calculate_statistic', 'block_course_statistic'));

        return $this->content;
    }
}