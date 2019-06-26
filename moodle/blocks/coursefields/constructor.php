<?php
defined('MOODLE_INTERNAL') || die();
require_once('../../config.php');
require_once('list_form.php');

function create_start_object($course, $info, $course_innfo_id = '') {
    $Object = new stdClass();
    $Object->internal_courseid = $course->id;
    $Object->parentid = $info['partnerid'];
    $Object->id = $course_innfo_id;
    $Object->title = $course->fullname;
    $Object->started_at = gmdate("Y-m-d", (int)$course->startdate);
    $Object->finished_at = gmdate("Y-m-d", (int)$course->enddate);
//    $Object->enrollment_finished_at = gmdate("Y-m-d", (int)$a);
    $Object->image = '';
    $Object->description = $course->summary;
    $Object->competences = '';
    $Object->requirements = new stdClass();
    $Object->content = '';
    $Object->external_url = $info['courselink'].$course->id;
    $Object->direction = new stdClass();
    $Object->institution = $info['institution'];
    $Object->duration = '';
    $Object->lectures = '';
    $Object->language = '';
    $Object->cert = '';
    $Object->visitors = '';
    $Object->teachers = new stdClass();
    $Object->teachers->teacher[0]->title = '';
    $Object->teachers->teacher[0]->image = '';
    $Object->teachers->teacher[0]->description = '';
    $Object->transfers = new stdClass();
    $Object->transfers->courseTransfer[0]->institution_id = '';
    $Object->transfers->courseTransfer[0]->direction_id = '';
    $Object->results = '';
    $Object->accreditated = '';
    $Object->hours = '';
    $Object->hours_per_week = '';
    $Object->ness_version = '';
    $Object->promo_url = '';
    $Object->promo_lang = '';
    $Object->subtitles_lang = '';
    $Object->estimation_tools = '';
    $Object->proctoring_service = '';
    $Object->sessionid = '';
}

function create_full_field($Object) {
    $mform = new listform();
    $mform->add_header('Свойства курса', 'course');
    $mform->add_simple_text(get_string('title', 'block_coursefields'), $Object->title, 'title');
    $mform->add_simple_text(get_string('parentid', 'block_coursefields'), $Object->partnerid, 'parentid');
    $mform->add_textfield(get_string('image', 'block_coursefields'), $Object->image, 'image');
    $mform->add_simple_text(get_string('description',  'block_coursefields'), $Object->description, 'description', 1);
    $mform->add_text_editor(get_string('competences', 'block_coursefields'), $Object->competences, 'competences');
    $mform->add_text_editor(get_string('requirements', 'block_coursefields'), $Object->requirements, 'requirements');
    $mform->add_simple_text(get_string('external_url', 'block_coursefields'), $Object->external_url, 'external_url', 1);
//    $mform->add_text_editor(get_string('direction', 'block_coursefields'), $Object->direction, 'direction', 1);
    $mform->add_simple_text(get_string('institution', 'block_coursefields'), $Object->institution, 'institution', 1);
    $mform->add_textfield(get_string('duration', 'block_coursefields'), $Object->duration, 'duration', 1);
    $mform->add_textfield(get_string('lectures', 'block_coursefields'), $Object->lectures, 'lectures');
    $mform->add_textfield(get_string('language', 'block_coursefields'), $Object->language, 'language');
    $mform->add_checkbox(get_string('cert', 'block_coursefields'), $Object->cert, 'cert', $Object->cert);
    $mform->add_textfield(get_string('visitors', 'block_coursefields'), $Object->visitors, 'visitors');
    $mform->add_text_editor(get_string('results', 'block_coursefields'), $Object->results, 'results');
    $mform->add_textfield(get_string('accreditated', 'block_coursefields'), $Object->accreditated, 'accreditated');
    $mform->add_textfield(get_string('hours', 'block_coursefields'), $Object->hours, 'hours');
    $mform->add_textfield(get_string('hours_per_week', 'block_coursefields'), $Object->hours_per_week, 'hours_per_week');
    $mform->add_textfield(get_string('business_version', 'block_coursefields'), $Object->business_version, 'business_version', 1);
    $mform->add_textfield(get_string('promo_url', 'block_coursefields'), $Object->promo_url, 'promo_url');
    $mform->add_textfield(get_string('promo_lang', 'block_coursefields'), $Object->promo_lang, 'promo_lang');
    $mform->add_textfield(get_string('subtitles_lang', 'block_coursefields'), $Object->subtitles_lang, 'subtitles_lang');
    $mform->add_textfield(get_string('estimation_tools', 'block_coursefields'), $Object->estimation_tools, 'estimation_tools');
    $mform->add_textfield(get_string('proctoring_service', 'block_coursefields'), $Object->proctoring_service, 'proctoring_service');
    $mform->add_textfield(get_string('sessionid', 'block_coursefields'), $Object->sessionid, 'sessionid');
    $mform->add_header('Преподаватели', 'teachers');
    $mform->add_textfield(get_string('t_title', 'block_coursefields'), $Object->teachers->teacher[0]->title, 't_title', 1);
    $mform->add_textfield(get_string('t_image', 'block_coursefields'), $Object->teachers->teacher[0]->image, 't_image');
    $mform->add_textfield(get_string('t_description', 'block_coursefields'), $Object->teachers->teacher[0]->description, 't_description');
    $mform->add_header('Информация о перезачётах', 'coursetransfer');
    $mform->add_textfield(get_string('institution_id', 'block_coursefields'), $Object->transfers->courseTransfer[0]->institution_id, 'institution_id', 1);
    $mform->add_textfield(get_string('direction_id', 'block_coursefields'), $Object->transfers->courseTransfer[0]->direction_id, 'direction_id', 1);
    $mform->add_act_button();
    return $mform;
}

function create_simple_text($Object) {
    $mform = new listform();
    $mform->add_header('Свойства курса', 'course');
    $mform->add_simple_text(get_string('title', 'block_coursefields'), $Object->title, 'title');
    $mform->add_simple_text(get_string('parentid', 'block_coursefields'), $Object->partnerid, 'parentid');
    $mform->add_simple_text(get_string('image', 'block_coursefields'), $Object->image, 'image');
    $mform->add_simple_text(get_string('description',  'block_coursefields'), $Object->description, 'description', 1);
    $mform->add_simple_text(get_string('competences', 'block_coursefields'), $Object->competences, 'competences');
    $mform->add_simple_text(get_string('requirements', 'block_coursefields'), $Object->requirements, 'requirements');
    $mform->add_simple_text(get_string('external_url', 'block_coursefields'), $Object->external_url, 'external_url', 1);
//    $mform->add_simple_text(get_string('direction', 'block_coursefields'), $Object->direction, 'direction', 1);
    $mform->add_simple_text(get_string('institution', 'block_coursefields'), $Object->institution, 'institution', 1);
    $mform->add_simple_text(get_string('duration', 'block_coursefields'), $Object->duration, 'duration', 1);
    $mform->add_simple_text(get_string('lectures', 'block_coursefields'), $Object->lectures, 'lectures');
    $mform->add_simple_text(get_string('language', 'block_coursefields'), $Object->language, 'language');
    $mform->add_simple_text(get_string('cert', 'block_coursefields'), $Object->cert, 'cert', 1);
    $mform->add_simple_text(get_string('visitors', 'block_coursefields'), $Object->visitors, 'visitors');
    $mform->add_simple_text(get_string('results', 'block_coursefields'), $Object->results, 'results');
    $mform->add_simple_text(get_string('accreditated', 'block_coursefields'), $Object->accreditated, 'accreditated');
    $mform->add_simple_text(get_string('hours', 'block_coursefields'), $Object->hours, 'hours');
    $mform->add_simple_text(get_string('hours_per_week', 'block_coursefields'), $Object->hours_per_week, 'hours_per_week');
    $mform->add_simple_text(get_string('business_version', 'block_coursefields'), $Object->business_version, 'business_version', 1);
    $mform->add_simple_text(get_string('promo_url', 'block_coursefields'), $Object->promo_url, 'promo_url');
    $mform->add_simple_text(get_string('promo_lang', 'block_coursefields'), $Object->promo_lang, 'promo_lang');
    $mform->add_simple_text(get_string('subtitles_lang', 'block_coursefields'), $Object->subtitles_lang, 'subtitles_lang');
    $mform->add_simple_text(get_string('estimation_tools', 'block_coursefields'), $Object->estimation_tools, 'estimation_tools');
    $mform->add_simple_text(get_string('proctoring_service', 'block_coursefields'), $Object->proctoring_service, 'proctoring_service');
    $mform->add_simple_text(get_string('sessionid', 'block_coursefields'), $Object->sessionid, 'sessionid');
    $mform->add_header('Преподаватели', 'teachers');
    $mform->add_simple_text(get_string('t_title', 'block_coursefields'), $Object->teachers->teacher[0]->title, 't_title', 1);
    $mform->add_simple_text(get_string('t_image', 'block_coursefields'), $Object->teachers->teacher[0]->image, 't_image');
    $mform->add_simple_text(get_string('t_description', 'block_coursefields'), $Object->teachers->teacher[0]->description, 't_description');
    $mform->add_header('Информация о перезачётах', 'coursetransfer');
    $mform->add_simple_text(get_string('institution_id', 'block_coursefields'), $Object->transfers->courseTransfer[0]->institution_id, 'institution_id', 1);
    $mform->add_simple_text(get_string('direction_id', 'block_coursefields'), $Object->transfers->courseTransfer[0]->direction_id, 'direction_id', 1);
    $mform->add_act_button();

    return $mform;
}

function createMainField($course, $info) {
    $courseobject = new stdClass();
    $courseobject->courseid = $course->id;
    $courseobject->partnerid = $info['partnerid'];
    $courseobject->title = $course->fullname;
    $courseobject->started_at = gmdate("Y-m-d", (int)$course->startdate);
    $courseobject->finished_at = gmdate("Y-m-d", (int)$course->enddate);
    $courseobject->enrollment_finished_at = '';
    $courseobject->image = '';
    $courseobject->description = $course->summary;
    $courseobject->competences = '';
    $courseobject->requirements = '';
    $courseobject->content = '';
    $courseobject->external_url = $info['courselink'].$course->id;
    $courseobject->direction = '01.01.1011';
    $courseobject->institution = $info['institution'];
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
//    $courseobject->proctoring_service = 'Examus';
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

function createEndObjects($data, $courseobject, $teacherObject, $coursetransferObject, $info) {
    $courseobject->image = $data->image;
    $courseobject->competences = $data->competences["text"];      //в выходе editора массив с элементом 'text' (в html)
    $courseobject->requirements = $data->requirements["text"];
//    $courseobject->direction = $data->direction;
    $courseobject->duration = $data->duration;
    $courseobject->lectures = $data->lectures;
    $courseobject->language = $data->language;
//    if ($data->cert == '1') {
//        $courseobject->cert = 'true';
//    } else {
//        $courseobject->cert = 'false';
//    }
    $courseobject->results = $data->results['text'];
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

//    if ($courseobject->cert == 'true') {
//        $courseobject->cert = 1;
//    } else {
//        $courseobject->cert = 0;
//    }
    $mform = new listform();
    $mform->add_header('Свойства курса', 'course');
    $mform->add_simple_text(get_string('title', 'block_coursefields'), $courseobject->title, 'title');
    $mform->add_simple_text(get_string('parentid', 'block_coursefields'), $courseobject->partnerid, 'parentid');
//    $mform->add_simple_text();
//    $mform->add_simple_text();
    $mform->add_textfield(get_string('image', 'block_coursefields'), $courseobject->image, 'image');
    $mform->add_simple_text(get_string('description',  'block_coursefields'), $courseobject->description, 'description', 1);
    $mform->add_text_editor(get_string('competences', 'block_coursefields'), $courseobject->competences, 'competences');
    $mform->add_text_editor(get_string('requirements', 'block_coursefields'), $courseobject->requirements, 'requirements');
    $mform->add_simple_text(get_string('external_url', 'block_coursefields'), $courseobject->external_url, 'external_url', 1);
//    $mform->add_text_editor(get_string('direction', 'block_coursefields'), $courseobject->direction, 'direction', 1);
    $mform->add_simple_text(get_string('institution', 'block_coursefields'), $courseobject->institution, 'institution', 1);
    $mform->add_textfield(get_string('duration', 'block_coursefields'), $courseobject->duration, 'duration', 1);
    $mform->add_textfield(get_string('lectures', 'block_coursefields'), $courseobject->lectures, 'lectures');
    $mform->add_textfield(get_string('language', 'block_coursefields'), $courseobject->language, 'language');
    $mform->add_checkbox(get_string('cert', 'block_coursefields'), $courseobject->cert, 'cert', $courseobject->cert);
    $mform->add_textfield(get_string('visitors', 'block_coursefields'), $courseobject->visitors, 'visitors');
    $mform->add_text_editor(get_string('results', 'block_coursefields'), $courseobject->results, 'results');
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

function createSimpleForm($courseobject, $teacherObject, $coursetransferObject, $is_student) {
    $mform = new listform();
    $mform->add_header('Свойства курса', 'course');
    $mform->add_simple_text(get_string('title', 'block_coursefields'), $courseobject->title, 'title');
    $mform->add_simple_text(get_string('parentid', 'block_coursefields'), $courseobject->partnerid, 'parentid');
//    $mform->add_simple_text();
//    $mform->add_simple_text();
    $mform->add_simple_text(get_string('image', 'block_coursefields'), $courseobject->image, 'image');
    $mform->add_simple_text(get_string('description',  'block_coursefields'), $courseobject->description, 'description', 1);
    $mform->add_simple_text(get_string('competences', 'block_coursefields'), $courseobject->competences, 'competences');
    $mform->add_simple_text(get_string('requirements', 'block_coursefields'), $courseobject->requirements, 'requirements');
    $mform->add_simple_text(get_string('external_url', 'block_coursefields'), $courseobject->external_url, 'external_url', 1);
//    $mform->add_text_editor(get_string('direction', 'block_coursefields'), $courseobject->direction, 'direction', 1);
    $mform->add_simple_text(get_string('institution', 'block_coursefields'), $courseobject->institution, 'institution', 1);
    $mform->add_simple_text(get_string('duration', 'block_coursefields'), $courseobject->duration, 'duration', 1);
    $mform->add_simple_text(get_string('lectures', 'block_coursefields'), $courseobject->lectures, 'lectures');
    $mform->add_simple_text(get_string('language', 'block_coursefields'), $courseobject->language, 'language');
    $mform->add_simple_text(get_string('cert', 'block_coursefields'), $courseobject->cert, 'cert', 1);
    $mform->add_simple_text(get_string('visitors', 'block_coursefields'), $courseobject->visitors, 'visitors');
    $mform->add_simple_text(get_string('results', 'block_coursefields'), $courseobject->results, 'results');
    $mform->add_simple_text(get_string('accreditated', 'block_coursefields'), $courseobject->accreditated, 'accreditated');
    $mform->add_simple_text(get_string('hours', 'block_coursefields'), $courseobject->hours, 'hours');
    $mform->add_simple_text(get_string('hours_per_week', 'block_coursefields'), $courseobject->hours_per_week, 'hours_per_week');
    $mform->add_simple_text(get_string('business_version', 'block_coursefields'), $courseobject->business_version, 'business_version', 1);
    $mform->add_simple_text(get_string('promo_url', 'block_coursefields'), $courseobject->promo_url, 'promo_url');
    $mform->add_simple_text(get_string('promo_lang', 'block_coursefields'), $courseobject->promo_lang, 'promo_lang');
    $mform->add_simple_text(get_string('subtitles_lang', 'block_coursefields'), $courseobject->subtitles_lang, 'subtitles_lang');
    $mform->add_simple_text(get_string('estimation_tools', 'block_coursefields'), $courseobject->estimation_tools, 'estimation_tools');
    $mform->add_simple_text(get_string('proctoring_service', 'block_coursefields'), $courseobject->proctoring_service, 'proctoring_service');
    $mform->add_simple_text(get_string('sessionid', 'block_coursefields'), $courseobject->sessionid, 'sessionid');
    $mform->add_header('Преподаватели', 'teachers');
    $mform->add_simple_text(get_string('t_title', 'block_coursefields'), $teacherObject->t_title, 't_title', 1);
    $mform->add_simple_text(get_string('t_image', 'block_coursefields'), $teacherObject->t_image, 't_image');
    $mform->add_simple_text(get_string('t_description', 'block_coursefields'), $teacherObject->t_description, 't_description');
    $mform->add_header('Информация о перезачётах', 'coursetransfer');
    $mform->add_simple_text(get_string('institution_id', 'block_coursefields'), $coursetransferObject->institution_id, 'institution_id', 1);
    $mform->add_simple_text(get_string('direction_id', 'block_coursefields'), $coursetransferObject->direction_id, 'direction_id', 1);
    if ($is_student == false) {
        $mform->add_act_button();
    }
    return $mform;
}

function is_dbobj_exist($courseid, $DB) {
    $exist['object'] = $DB->record_exists('block_coursefields_main', array('courseid' => $courseid));
    $exist['teacherObject'] = $DB->record_exists('block_coursefields_teacher', array('courseid' => $courseid));
    $exist['coursetransfeObject'] = $DB->record_exists('block_coursefields_coursetr', array('courseid' => $courseid));
    return $exist;
}

function is_user_student($USER)
{
    if (user_has_role_assignment($USER->id, 5) == true
        OR user_has_role_assignment($USER->id, 6) == true
        OR user_has_role_assignment($USER->id, 7) == true) {
        return true;
    } else {
        return false;
    }
}

//function boolen_convert($expression) {
//    if ($expression == '0') {
//        $expression = 'false';}
//    if ($expression == '1'){
//        $expression = 'true';}
//    if ($expression == true) {
//        $expression = '1';}
//    if ($expression == false) {
//        $expression = '0';}
//}

function cleanHTMLString($string) {
    strip_tags($string, '<p>');
    return $string;
}

function jsonObject($courseid, $DB) {
    $courseobject = $DB->get_record('block_coursefields_main', array('courseid' => $courseid), '*', MUST_EXIST);
    $teacherObject = $DB->get_record('block_coursefields_teacher', array('courseid' => $courseid), '*', MUST_EXIST);
    $coursetransferObject = $DB->get_record('block_coursefields_coursetr', array('courseid' => $courseid), '*', MUST_EXIST);
    unset($courseobject->id);
    unset($teacherObject->id);
    unset($coursetransferObject->id);
    $courseobject->competences = cleanHTMLString($courseobject->competences);
//    $courseobject->duration = cleanHTMLString($courseobject->duration);
    $courseobject->teacher = $teacherObject;
    $courseobject->coursetransfer = $coursetransferObject;
    $myJSON = json_encode($courseobject);
    return $myJSON;
}

function  add_course($jsonString, $url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_REFERER, 'https://mooc.vsu.ru/');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonString);
    $json_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($status != 201) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);
    $response = json_decode($json_response, true);
}

//function update_course() {
//
//}

//function change_status() {
//
//}

function get_status_of_course($courseid_platform, $info) {
    $curl = curl_init($info['get_status_url'].$courseid_platform);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $info['get_status_url'].$courseid_platform,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ]);
    $resp = curl_exec($curl);
    curl_close($curl);
}