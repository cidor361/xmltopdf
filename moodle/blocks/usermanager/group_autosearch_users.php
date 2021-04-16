<?php
require_once('../../config.php');
require_once('lib.php');
require_once('group_autosearch_users_form.php');
require_once('connect.php');

global $DB, $SESSION;

$course = $DB->get_record('course',array('id'=>$SESSION->courseid));
require_login($course, true);

$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/blocks/usermanager/group_autosearch_users.php', array('id' => $course->id));
$PAGE->navbar->add(get_string('pluginname', 'block_usermanager'));

$PAGE->set_title(get_string('pluginname', 'block_usermanager'));
$PAGE->set_heading(get_string('pluginname', 'block_usermanager'));

echo $OUTPUT->header();
//$sql = "SELECT * FROM mdl_block_vsucourse_new WHERE cid='".$course->id."' AND status='0';";
//$disciplins = $DB->get_records_sql($sql);
//$SESSION->disciplins = $disciplins;

$SESSION->disciplins = get_semestr_of_subject_oci_old($conn, $course);

$mform = new group_autosearch_users_form();

if ($mform->is_cancelled()) {
    $url = new moodle_url('/course/view.php?id='.$course->id);
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

//echo var_dump($disciplins).'</br>';

/*
$sql = "SELECT * FROM contingent.moodle_study_work_view LIMIT 1;";
$stid = oci_execute($conn, $sql);

if(!$stid) {
    $e = oci_error($conn);
    echo htmlentities($e['message']);
}

$r = oci_execute($stid);
if(!$r){
    $e = oci_error($stid);
    echo htmlentities($e['message']);
}

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo var_dump($row);
}

oci_free_statement($stid);
oci_close($conn);
*/

echo $OUTPUT->footer();
