<?php
require_once('../../config.php');
require_once('list_form.php');
//require_once('constructor.php');

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
$exist['coursetransfeObject'] = $DB->record_exists('block_coursefields_coursetransfer', array('courseid' => $courseid));

if ($exist['object'] == 1) {
    $courseobject = $DB->get_record('block_coursefields_main', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $courseobject = createField();
}
if ($exist['teacherObject'] == 1) {
    $teacherObject = $DB->get_record('block_coursefields_teacher', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $teacherObject = createTeacherField();
}
if ($exist['coursetransfeObject']) {
    $coursetransferObject = $DB->get_record('block_coursefields_coursetransfer', array('courseid' => $courseid), '*', MUST_EXIST);
} else {
    $coursetransferObject = createCoursetransferField();
}

if($mform->is_cancelled()) {

} else if ($object = $mform->get_data()) {
    $object->courseid = $courseid;
    if ($exist['object'] == null) {
        $DB->insert_record('block_coursefields', $object, '*', MUST_EXIST);
        $DB->insert_record('block_coursefields', $teacherObject, '*', MUST_EXIST);
        $DB->insert_record('block_coursefields', $coursetransfeObject, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefields', $object);
    }
} else {
$_SESSION['courseid'] = $courseid;
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();