<?php
//moodle 3.x
require_once('config.php');
require_once($CFG->libdir.'/blocklib.php');
if (is_siteadmin()) {
    $courses = get_courses();//can be feed categoryid to just effect one category
    foreach($courses as $course) {
        $context = context_course::instance($course->id);
        blocks_delete_all_for_context($context->id);
        blocks_add_default_course_blocks($course);
        echo 'Course '.$course->id.' done';
    }
}
?>
