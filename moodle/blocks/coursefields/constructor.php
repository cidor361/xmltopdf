<?php
require_once('../../config.php');
require_once('list_form.php');
function createMainField($course) {
    $courseobject = new stdClass();
    $courseobject->courseid = $course->id;
    $courseobject->partnerid = '';
    $courseobject->title = $course->fullname;
    $courseobject->started_at = gmdate($course->startdate, 'y-m-d');
    $courseobject->finished_at = gmdate($course->enddate, 'y-m-d');
    $courseobject->enrollment_finished_at = '';
    $courseobject->image = '';
    $courseobject->description = $course->summary;
    $courseobject->competences = '';
    $courseobject->requirements = '';
    $courseobject->content = '';
    $courseobject->external_url = '';
    $courseobject->direction = '';
    $courseobject->institution = '';
    $courseobject->duration = '';        //TODO: $course->timecreated; сюда перевод времени!
    $courseobject->lectures = '';
    $courseobject->language = 'ru';
    $courseobject->cert = 'false';
    $courseobject->visitors = '';
    $courseobject->teachers = '';
    $courseobject->transfers = '';
    $courseobject->results = '';
    $courseobject->hours = '';
    $courseobject->hours_per_week = '';
    $courseobject->business_version = '';
    $courseobject->promo_url = '';
    $courseobject->promo_lang = '';
    $courseobject->subtitles_lang = '';
    $courseobject->estimation_tools = '';
    $courseobject->proctoring_service = '';
    $courseobject->sessionid = '';
    return $courseobject;
}
function createTeacherField($course) {
    $teacherObject = new stdClass();
    $teacherObject->courseid = $course->id;
    $teacherObject->t_title = '';
    $teacherObject->t_image = '';
    $teacherObject->t_description = '';
    return $teacherObject;
}
function createCoursetransferField($course){
    $coursetransferObject = new stdClass();
    $coursetransferObject->courseid = $course->id;
    $coursetransferObject->institution_id = '';
    $coursetransferObject->direction_id = '';
    return $coursetransferObject;
}
function createEndObjects($data, $courseobject, $teacherObject, $coursetransferObject) {
    $courseobject->partnerid = $data->partnerid;
    $courseobject->title = $data->title;
    $courseobject->started_at = $data->started_atgmdate;
    $courseobject->finished_at = $data->finished_atgmdate;
    $courseobject->enrollment_finished_at = $data->enrollment_finished_at;
    $courseobject->image = $data->image;
    $courseobject->description = $data->description;
    $courseobject->competences = $data->competences;
    $courseobject->requirements = $data->requirements;
    $courseobject->content = $data->content;
    $courseobject->external_url = $data->external_url;
    $courseobject->direction = $data->direction;
    $courseobject->institution = $data->institution;
    $courseobject->duration = $data->duration;
    $courseobject->lectures = $data->lectures;
    $courseobject->language = $data->language;
    $courseobject->cert = $data->cert;
    $courseobject->visitors = $data->visitors;
    $courseobject->teachers = $data->teachers;
    $courseobject->transfers = $data->transfers;
    $courseobject->results = $data->results;
    $courseobject->hours = $data->hours;
    $courseobject->hours_per_week = $data->hours_per_week;
    $courseobject->business_version = $data->business_version;
    $courseobject->promo_url = $data->promo_url;
    $courseobject->promo_lang = $data->promo_lang;
    $courseobject->subtitles_lang = $data->subtitles_lang;
    $courseobject->estimation_tools = $data->estimation_tools;
    $courseobject->proctoring_service = $data->proctoring_service;
    $courseobject->sessionid = $data->sessionid;
    $teacherObject->t_title = $data->t_title;
    $teacherObject->t_image = $data->t_image;
    $teacherObject->t_description = $data->t_description;
    $coursetransferObject->institution_id = $data->institution_id;
    $coursetransferObject->direction_id = $data->direction_id;
    $big_object = new stdClass();
    $big_object->courseobject = $courseobject;
    $big_object->teacherObject = $teacherObject;
    $big_object->coursetransferObject = $coursetransferObject;
    return $big_object;

}
function createForm($courseobject, $teacherObject, $coursetransferObject) {
    $mform = new listform();
    $mform->add_simple_text(get_string('block_coursefields', 'parentid'), $courseobject->parentid, 'parentid');
    $mform->add_textfield(get_string('block_coursefields', 'title'), $courseobject->partnerid, 'title');
//    $mform->add_simple_text();
//    $mform->add_simple_text();
    $mform->add_textfield(get_string('block_coursefields', 'image'), $courseobject->image, 'image');
    $mform->add_text_editor(get_string('course_field', 'description'), $courseobject->description, 'description');
    $mform->add_text_editor(get_string('block_coursefields', 'competences'), $courseobject->competences, 'competences');
    $mform->add_text_editor(get_string('block_coursefields', 'requirements'), $courseobject->requirements, 'requirements');
    $mform->add_text_editor(get_string('block_coursefields', 'content'), $courseobject->content, 'content');
    $mform->add_textfield(get_string('block_coursefields', 'external_url'), $courseobject->external_url, 'external_url');
    $mform->add_text_editor(get_string('block_coursefields', 'direction'), $courseobject->direction, 'direction');
    $mform->add_textfield(get_string('block_coursefields', 'institution'), $courseobject->institution, 'institution');
    $mform->add_text_editor(get_string('block_coursefields', 'duration'), $courseobject->duration, 'duration');
    $mform->add_textfield(get_string('block_coursefields', 'lectures'), $courseobject->lectures, 'lectures');
    $mform->add_textfield(get_string('block_coursefields', 'language'), $courseobject->language, 'language');
    $mform->add_textfield(get_string('block_coursefields', 'cert'), $courseobject->cert, 'cert');
    $mform->add_textfield(get_string('block_coursefields', 'visitors'), $courseobject->visitors, 'visitors');
    $mform->add_textfield(get_string('block_coursefields', 'results'), $courseobject->results, 'results');
    $mform->add_textfield(get_string('block_coursefields', 'accreditated'), $courseobject->accreditated, 'accreditated');
    $mform->add_textfield(get_string('block_coursefields', 'hours'), $courseobject->hours, 'hours');
    $mform->add_textfield(get_string('block_coursefields', 'hours_per_week'), $courseobject->hours_per_week, 'hours_per_week');
    $mform->add_textfield(get_string('block_coursefields', 'business_version'), $courseobject->business_version, 'business_version');
    $mform->add_textfield(get_string('block_coursefields', 'business_version'), $courseobject->business_version, 'business_version');
    $mform->add_textfield(get_string('block_coursefields', 'promo_url'), $courseobject->promo_url, 'promo_url');
    $mform->add_textfield(get_string('block_coursefields', 'promo_lang'), $courseobject->promo_lang, 'promo_lang');
    $mform->add_textfield(get_string('block_coursefields', 'subtitles_lang'), $courseobject->subtitles_lang, 'subtitles_lang');
    $mform->add_textfield(get_string('block_coursefields', 'estimation_tools'), $courseobject->estimation_tools, 'estimation_tools');
    $mform->add_textfield(get_string('block_coursefields', 'proctoring_service'), $courseobject->proctoring_service, 'proctoring_service');
    $mform->add_textfield(get_string('block_coursefields', 'sessionid'), $courseobject->sessionid, 'sessionid');

    $mform->add_textfield(get_string('block_coursefields', 't_title'), $teacherObject->t_title, 't_title');
    $mform->add_textfield(get_string('block_coursefields', 't_image'), $teacherObject->t_image, 't_image');
    $mform->add_textfield(get_string('block_coursefields', 't_description'), $teacherObject->t_description, 't_description');

    $mform->add_textfield(get_string('block_coursefields', 'institution_id'), $coursetransferObject->institution_id, 'institution_id');
    $mform->add_textfield(get_string('block_coursefields', 'institution_id'), $coursetransferObject->institution_id, 'institution_id');
    $mform->add_act_button();

    return $mform;
}