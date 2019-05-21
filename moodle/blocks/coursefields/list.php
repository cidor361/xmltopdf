<?php
require_once('../../config.php');
require_once('constructor.php');

global $PAGE, $OUTPUT, $DB;
$courseid = $_SESSION['courseid'];
require_login($courseid);

$PAGE->set_url('/blocks/coursefield/list.php');
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

$mform = createForm($courseobject, $teacherObject, $coursetransferObject);

if($mform->is_cancelled()) {

} else if ($courseobject_data = $mform->get_data()) {
    $big_object = createEndObjects($courseobject_data, $courseobject, $teacherObject, $coursetransferObject, $courseid);
    $courseobject = $big_object->courseobject;
    $teacherObject = $big_object->teacherObject;
    $coursetransferObject = $big_object->coursetransferObject;
    if ($exist['object'] == null) {
        $DB->insert_record('block_coursefields_main', $courseobject, '*', MUST_EXIST);
    } else {
        $DB->update_record('block_coursefields_main', $courseobject);
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
}

$url = new moodle_url('/blocks/coursefields/sendlist.php');
echo $OUTPUT->header();
$mform->display();
echo '<a href='.$url.'>Отправить</a>';
echo $OUTPUT->footer();