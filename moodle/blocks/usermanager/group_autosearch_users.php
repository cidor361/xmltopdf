<?php
require_once('../../config.php');
require_once('lib.php');
require_once('group_autosearch_users_form.php');

//Should be uncomment when oracle integration will be removed
require_once('connect.php');

global $DB, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
$courseid = $course->id;
require_login($course, true);
$coursecontext = context_course::instance($courseid);
if (!has_capability('block/usermanager:manageuser', $coursecontext)) {
    die(get_string('access_error', 'block_usermanager'));
}

$PAGE->set_context($coursecontext);
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/group_autosearch_users.php', array('id' => $courseid));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();
//echo var_dump(get_semestr_of_subject_oci_old($conn, $courseid));
$SESSION->disciplins = get_semestr_of_subject_oci_old($conn, $courseid);
//Should be uncomment when oracle integration will be removed
//$sql = "SELECT * FROM mdl_block_vsucourse_new WHERE cid='".$course->id."' AND status='0';";
//$SESSION->disciplins = $DB->get_records_sql($sql);

$mform = new group_autosearch_users_form();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);

} else if ($fromform = $mform->get_data()) {
    $mform->display();
    $groups = array();
    foreach ($fromform as $key=>$group) {
        if ($group == 1) {
            array_push($groups, $key);
        }
    }
    $SESSION->groups = $groups;
    $url = new moodle_url('/blocks/usermanager/group_autoenrol.php');
    redirect($url);

}else {
    $mform->display();

}

echo $OUTPUT->footer();
