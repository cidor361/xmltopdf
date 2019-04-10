<?php
defined('MOODLE_INTERNAL') || die();
require_once('../../config.php');
require_once('list_form.php');
function createMainField($course) {
    $courseobject = new stdClass();
    $courseobject->courseid = $course->id;
    $courseobject->partnerid = '???';
    $courseobject->title = $course->fullname;
    $courseobject->started_at = gmdate("Y-m-d", (int)$course->startdate);
    $courseobject->finished_at = gmdate("Y-m-d", (int)$course->enddate);
    $courseobject->enrollment_finished_at = '';
    $courseobject->image = '';
    $courseobject->description = $course->summary;
    $courseobject->competences = '';
    $courseobject->requirements = '';
    $courseobject->content = '';
    $courseobject->external_url = 'http://something.ru';
    $courseobject->direction = '01.01.1011';
    $courseobject->institution = '';
    $courseobject->duration = '';
    $courseobject->lectures = '';
    $courseobject->language = 'ru';
    $courseobject->cert = 'false';
    $courseobject->visitors = '';
    $courseobject->results = '';
    $courseobject->hours = '';
    $courseobject->hours_per_week = '';
    $courseobject->business_version = '';
    $courseobject->promo_url = '';
    $courseobject->promo_lang = '';
    $courseobject->subtitles_lang = '';
    $courseobject->estimation_tools = '';
    $courseobject->proctoring_service = 'Examus';
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
    $courseobject->image = $data->image;
    $courseobject->competences = $data->competences["text"];      //в выходе editора массив с элементом 'text' (в html)
    $courseobject->requirements = $data->requirements["text"];
//    $courseobject->direction = $data->direction;
    $courseobject->institution = $data->institution;
    $courseobject->duration = $data->duration["text"];
    $courseobject->lectures = $data->lectures;
    $courseobject->language = $data->language;
    $courseobject->cert = $data->cert;
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
    $mform->add_header('Свойства курса', 'course');
    $mform->add_simple_text(get_string('title', 'block_coursefields'), $courseobject->title, 'title');
    $mform->add_simple_text(get_string('parentid', 'block_coursefields'), $courseobject->partnerid, 'parentid');
//    $mform->add_simple_text();
//    $mform->add_simple_text();
    $mform->add_textfield(get_string('image', 'block_coursefields'), $courseobject->image, 'image');
    $mform->add_text_editor(get_string('description',  'block_coursefields'), $courseobject->description, 'description', 1);
    $mform->add_text_editor(get_string('competences', 'block_coursefields'), $courseobject->competences, 'competences');
    $mform->add_text_editor(get_string('requirements', 'block_coursefields'), $courseobject->requirements, 'requirements');
    $mform->add_simple_text(get_string('external_url', 'block_coursefields'), $courseobject->external_url, 'external_url', 1);
//    $mform->add_text_editor(get_string('direction', 'block_coursefields'), $courseobject->direction, 'direction', 1);
    $mform->add_textfield(get_string('institution', 'block_coursefields'), $courseobject->institution, 'institution', 1);
    $mform->add_text_editor(get_string('duration', 'block_coursefields'), $courseobject->duration, 'duration', 1);
    $mform->add_textfield(get_string('lectures', 'block_coursefields'), $courseobject->lectures, 'lectures');
    $mform->add_textfield(get_string('language', 'block_coursefields'), $courseobject->language, 'language');
    $mform->add_textfield(get_string('cert', 'block_coursefields'), $courseobject->cert, 'cert', 1);
    $mform->add_textfield(get_string('visitors', 'block_coursefields'), $courseobject->visitors, 'visitors');
    $mform->add_textfield(get_string('results', 'block_coursefields'), $courseobject->results, 'results');
    $mform->add_textfield(get_string('accreditated', 'block_coursefields'), $courseobject->accreditated, 'accreditated');
    $mform->add_textfield(get_string('hours', 'block_coursefields'), $courseobject->hours, 'hours');
    $mform->add_textfield(get_string('hours_per_week', 'block_coursefields'), $courseobject->hours_per_week, 'hours_per_week');
    $mform->add_textfield(get_string('business_version', 'block_coursefields'), $courseobject->business_version, 'business_version', 1);
    $mform->add_textfield(get_string('promo_url', 'block_coursefields'), $courseobject->promo_url, 'promo_url');
    $mform->add_textfield(get_string('promo_lang', 'block_coursefields'), $courseobject->promo_lang, 'promo_lang');
    $mform->add_textfield(get_string('subtitles_lang', 'block_coursefields'), $courseobject->subtitles_lang, 'subtitles_lang');
    $mform->add_textfield(get_string('estimation_tools', 'block_coursefields'), $courseobject->estimation_tools, 'estimation_tools');
    $mform->add_textfield(get_string('proctoring_service', 'block_coursefields'), $courseobject->proctoring_service, 'proctoring_service');
    $mform->add_textfield(get_string('sessionid', 'block_coursefields'), $courseobject->sessionid, 'sessionid');
    $mform->add_header('Преподаватели', 'teachers');
    $mform->add_textfield(get_string('t_title', 'block_coursefields'), $teacherObject->t_title, 't_title', 1);
    $mform->add_textfield(get_string('t_image', 'block_coursefields'), $teacherObject->t_image, 't_image');
    $mform->add_textfield(get_string('t_description', 'block_coursefields'), $teacherObject->t_description, 't_description');
    $mform->add_header('Информация о перезачётах', 'coursetransfer');
    $mform->add_textfield(get_string('institution_id', 'block_coursefields'), $coursetransferObject->institution_id, 'institution_id', 1);
    $mform->add_textfield(get_string('direction_id', 'block_coursefields'), $coursetransferObject->direction_id, 'direction_id', 1);
    $mform->add_act_button();

    return $mform;
}
