<?php
require_once('../../config.php');
require_once('constructor.php');

global $PAGE, $OUTPUT, $DB;
//require_login($courseid);

$courseid = $_GET['id'];
if($courseid == null) {
    $courseid = $_SESSION['courseid'];
}
$PAGE->set_url('/blocks/coursefield/list.php'.'?id='.$courseid);
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($courseid));
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$exist['object'] = $DB->record_exists('block_coursefields_main', array('courseid' => $courseid));
$exist['teacherObject'] = $DB->record_exists('block_coursefields_teacher', array('courseid' => $courseid));
$exist['coursetransfeObject'] = $DB->record_exists('block_coursefields_coursetr', array('courseid' => $courseid));

if ($exist['object'] == 1) {
    $courseobject = $DB->get_record('block_coursefields_main', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $courseobject = createMainField($course);
};
if ($exist['teacherObject'] == 1) {
    $teacherObject = $DB->get_record('block_coursefields_teacher', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $teacherObject = createTeacherField($course);
};
if ($exist['coursetransfeObject'] == 1) {
    $coursetransferObject = $DB->get_record('block_coursefields_coursetr', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $coursetransferObject = createCoursetransferField($course);
};
$mform = createForm($courseobject, $teacherObject,$coursetransferObject);
if($mform->is_cancelled()) {

} else if ($courseobject = $mform->get_data()) {
    $courseobject = $mform->get_data()->object;
    $teacherObject = $mform->get_data()->teacherObject;
    $coursetransferObject = $mform->get_data()->coursetransferObject;
    if ($exist['object'] == null) {
        $DB->insert_record('block_coursefields', $courseobject, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefields', $courseobject);
    }
    if ($exist['teacherObject'] == null) {
        $DB->insert_record('block_coursefields_teacher', $teacherObject, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefields_teacher', $teacherObject);
    }
    if ($exist['coursetransfeObject'] == null) {
        $DB->insert_record('block_coursefields_coursetr', $coursetransferObject, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefields_coursetr', $coursetransferObject);
    }
} else {
$_SESSION['courseid'] = $courseid;
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();