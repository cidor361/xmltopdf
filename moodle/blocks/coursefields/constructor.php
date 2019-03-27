<?php
require('list_form.php');                       //TODO: убрать!!!
function createMainField($course, $parentid) {
    $object = new stdClass();
    $object->courseid = $course->id;
    $object->partnerid = $parentid;
    $object->title = $course->fullname;
    $object->started_at = gmdate($course->startdate, 'y-m-d');
    $object->finished_at = gmdate($course->enddate, 'y-m-d');
    $object->enrollment_finished_at = '';
    $object->image = '';
    $object->description = $course->summary;
    $object->competences = '';
    $object->requirements = '';
    $object->content = '';
    $object->external_url = '';
    $object->direction = '';
    $object->institution = '';
    $object->duration = '';        //TODO: $course->timecreated; сюда перевод времени!
    $object->lectures = '';
    $object->language = '';
    $object->cert = '';
    $object->visitors = '';
    $object->teachers = '';
    $object->transfers = '';
    $object->results = '';
    $object->hours = '';
    $object->hours_per_week = '';
    $object->business_version = '';
    $object->promo_url = '';
    $object->promo_lang = '';
    $object->subtitles_lang = '';
    $object->estimation_tools = '';
    $object->proctoring_service = '';
    $object->sessionid = '';
    return $object;
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
function createEndObjects($data, $object, $teacherObject, $coursetransferObject) {
    $object->partnerid = $data->partnerid;
    $object->title = $data->title;
    $object->started_at = $data->started_atgmdate;
    $object->finished_at = $data->finished_atgmdate;
    $object->enrollment_finished_at = $data->enrollment_finished_at;
    $object->image = $data->image;
    $object->description = $data->description;
    $object->competences = $data->competences;
    $object->requirements = $data->requirements;
    $object->content = $data->content;
    $object->external_url = $data->external_url;
    $object->direction = $data->direction;
    $object->institution = $data->institution;
    $object->duration = $data->duration;
    $object->lectures = $data->lectures;
    $object->language = $data->language;
    $object->cert = $data->cert;
    $object->visitors = $data->visitors;
    $object->teachers = $data->teachers;
    $object->transfers = $data->transfers;
    $object->results = $data->results;
    $object->hours = $data->hours;
    $object->hours_per_week = $data->hours_per_week;
    $object->business_version = $data->business_version;
    $object->promo_url = $data->promo_url;
    $object->promo_lang = $data->promo_lang;
    $object->subtitles_lang = $data->subtitles_lang;
    $object->estimation_tools = $data->estimation_tools;
    $object->proctoring_service = $data->proctoring_service;
    $object->sessionid = $data->sessionid;
    $teacherObject->t_title = '';
    $teacherObject->t_image = '';
    $teacherObject->t_description = '';
}
function createForm($object, $teacherObject, $coursetransferObject) {
    $mform = new listform();
    $mform->add_simple_text(get_string('course_fields', 'parentid'), $object->parentid, 'parentid');
    $mform->add_textfield(get_string('course_fields', 'title'), $object->partnerid, 'title');
//    $mform->add_simple_text();
//    $mform->add_simple_text();
    $mform->add_textfield(get_string('course_fields', 'image'), $object->image, 'image');
    $mform->add_text_editor(get_string('course_field', 'description'), $object->description, 'description');
    $mform->add_text_editor(get_string('course_fields', 'competences'), $object->competences, 'competences');
    $mform->add_text_editor(get_string('course_fields', 'requirements'), $object->requirements, 'requirements');
    $mform->add_text_editor(get_string('course_fields', 'content'), $object->content, 'content');
    $mform->add_textfield(get_string('course_field', 'external_url'), $object->external_url, 'external_url');
    $mform->add_text_editor(get_string('course_fields', 'direction'), $object->direction, 'direction');
    $mform->add_textfield(get_string('course_fields', 'institution'), $object->institution, 'institution');
    $mform->add_text_editor(get_string('course_fields', 'duration'), $object->duration, 'duration');
    $mform->add_textfield(get_string('course_fields', 'lectures'), $object->lectures, 'lectures');
    $mform->add_textfield(get_string('course_fields', 'language'), $object->language, 'language');
    $mform->add_textfield(get_string('course_fields', 'cert'), $object->cert, 'cert');
    $mform->add_textfield(get_string('course_fields', 'visitors'), $object->visitors, 'visitors');
    $mform->add_textfield(get_string('course_fields', 'results'), $object->results, 'results');
    $mform->add_textfield(get_string('course_fields', 'accreditated'), $object->accreditated, 'accreditated');
    $mform->add_textfield(get_string('course_fields', 'hours'), $object->hours, 'hours');
    $mform->add_textfield(get_string('course_fields', 'hours_per_week'), $object->hours_per_week, 'hours_per_week');
    $mform->add_textfield(get_string('course_fields', 'business_version'), $object->business_version, 'business_version');
    $mform->add_textfield(get_string('course_fields', 'business_version'), $object->business_version, 'business_version');
    $mform->add_textfield(get_string('course_fields', 'promo_url'), $object->promo_url, 'promo_url');
    $mform->add_textfield(get_string('course_fields', 'promo_lang'), $object->promo_lang, 'promo_lang');
    $mform->add_textfield(get_string('course_fields', 'subtitles_lang'), $object->subtitles_lang, 'subtitles_lang');
    $mform->add_textfield(get_string('course_fields', 'estimation_tools'), $object->estimation_tools, 'estimation_tools');
    $mform->add_textfield(get_string('course_fields', 'proctoring_service'), $object->proctoring_service, 'proctoring_service');
    $mform->add_textfield(get_string('course_fields', 'sessionid'), $object->sessionid, 'sessionid');

    $mform->add_textfield(get_string('course_fields', 't_title'), $teacherObject->t_title, 't_title');
    $mform->add_textfield(get_string('course_fields', 't_image'), $teacherObject->t_image, 't_image');
    $mform->add_textfield(get_string('course_fields', 't_description'), $teacherObject->t_description, 't_description');

    $mform->add_textfield(get_string('course_fields', 'institution_id'), $coursetransferObject->institution_id, 'institution_id');
    $mform->add_textfield(get_string('course_fields', 'institution_id'), $coursetransferObject->institution_id, 'institution_id');

    return $mform;
}