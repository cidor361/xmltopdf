<?php
defined('MOODLE_INTERNAL') || die();
require_once('../../config.php');
require_once('list_form.php');

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
    $courseobject->external_url = 'http://sm-v-edi.main.vsu.ru/grebennikov/moodle/course/view.php?id='.$course->id;
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
    if ($data->cert == '1') {
        $courseobject->cert = 'true';
    } else {
        $courseobject->cert = 'false';
    }
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

//function getDBObject($course) {
//    $exist['object'] = $DB->record_exists('block_coursefields_main', array('courseid' => $courseid));
//    $exist['teacherObject'] = $DB->record_exists('block_coursefields_teacher', array('courseid' => $courseid));
//    $exist['coursetransfeObject'] = $DB->record_exists('block_coursefields_coursetr', array('courseid' => $courseid));
//
//    $courseobject = $DB->get_record('block_coursefields_main', array('courseid' => $courseid), '*', MUST_EXIST);
//    $teacherObject = $DB->get_record('block_coursefields_teacher', array('courseid' => $courseid), '*', MUST_EXIST);
//    $coursetransferObject = $DB->get_record('block_coursefields_coursetr', array('courseid' => $courseid), '*', MUST_EXIST);
//}

function createForm($courseobject, $teacherObject, $coursetransferObject) {

    if ($courseobject->cert == 'true') {
        $courseobject->cert = 1;
    } else {
        $courseobject->cert = 0;
    }
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
    $mform->add_checkbox(get_string('cert', 'block_coursefields'), $courseobject->cert, 'cert', 1);
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

function cleanHTMLString($string) {
    strip_tags($string, '<p>');
    return $string;
}


function jsonObject($courseid, $DB) {
    $courseobject = $DB->get_record('block_coursefields_main', array('courseid' => $courseid), '*', MUST_EXIST);
    $teacherObject = $DB->get_record('block_coursefields_teacher', array('courseid' => $courseid), '*', MUST_EXIST);
    $coursetransferObject = $DB->get_record('block_coursefields_coursetr', array('courseid' => $courseid), '*', MUST_EXIST);
    $courseobject->competences = cleanHTMLString($courseobject->competences);
//    $courseobject->duration = cleanHTMLString($courseobject->duration);
    $courseobject->teacher = $teacherObject;
    $courseobject->coursetransfer = $coursetransferObject;
    $myJSON = json_encode($courseobject);
    return $myJSON;
}

//function sendJsonObject($jsonString) {
//    $ch = curl_init('https://preprod.oeplatform.ru/api/cources/v0/course');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_POST, true); //переключаем запрос в POST
//    curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonString); //Это POST данные
////    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключим проверку сертификата https
////    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //из той же оперы
//    curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
//    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа (не много ли!?)
//    $Result = curl_exec($ch);
//    $err     = curl_errno( $ch );
//    $errmsg  = curl_error( $ch );
//    curl_close($ch);
//    return $errmsg;
//}


function sendJsonObject($jsonString) {
    $url = "https://preprod.oeplatform.ru/ru/api/cources/v0/course";
    $content = $jsonString;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($status != 201) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }


    curl_close($curl);

    $response = json_decode($json_response, true);
}

function is_user_student($USER) {
    if (user_has_role_assignment($USER->id, 5) == true
        OR user_has_role_assignment($USER->id, 6) == true
        OR user_has_role_assignment($USER->id, 7) == true) {
        return true;
    } else {
        return false;
    }
}