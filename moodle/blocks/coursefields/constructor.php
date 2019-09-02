<?php
defined('MOODLE_INTERNAL') || die();
require_once('../../config.php');
require_once('list_form.php');

function create_start_object($course, $info) {
    $Object = new stdClass();
    $Object->internal_courseid = $course->id;
    $Object->external_courseid = '';
    $Object->parentid = $info['partnerid'];
    $Object->title = $course->fullname;
    $Object->started_at = gmdate("Y-m-d", (int)$course->startdate);
    $Object->finished_at = gmdate("Y-m-d", (int)$course->enddate);
    $Object->enrollment_finished_at = '';//= gmdate("Y-m-d", (int)$a);
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
    $Object->cert = '0';
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
    return $Object;
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
//    $mform->add_textfield(get_string('visitors', 'block_coursefields'), $Object->visitors, 'visitors');
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

function create_simple_field($Object, $userid) {
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
//    $mform->add_simple_text(get_string('visitors', 'block_coursefields'), $Object->visitors, 'visitors');
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
    if (!is_user_student($userid)) {
        $mform->add_act_button();
    }
    return $mform;
}

function is_dbobj_exist($DB, $internal_courseid = null, $external_courseid = null) {
    if ($internal_courseid != null) {
        $exist = $DB->record_exists('block_coursefields', array('internal_courseid' => $internal_courseid));
    }
    if ($external_courseid != null) {
        $exist = $DB->record_exists('block_coursefields', array('internal_courseid' => $external_courseid));
    }
    return $exist;
}

function is_user_student($userid) {
    if (user_has_role_assignment($userid, 5) == true
        OR user_has_role_assignment($userid, 6) == true
        OR user_has_role_assignment($userid, 7) == true) {
        return true;
    } else {
        return false;
    }
}

function reformat_formdata_for_db($Object, $formdata, $external_courseid) {
    $Object_for_db = new stdClass();
    $Object_for_db->internal_courseid = $Object->internal_courseid;
    $Object_for_db->external_courseid = $external_courseid;
    $Object_for_db->id = $Object->id;
    $Object->image = $formdata->image;
    $Object->competences = $formdata->competences["text"];
    $Object->requirements = $formdata->requirements["text"];
    $Object->direction = $formdata->direction;
    $Object->duration = $formdata->duration;
    $Object->lectures = $formdata->lectures;
    $Object->language = $formdata->language;
    $Object->cert = boolen_convert($formdata->cert);
    $Object->results = $formdata->results["text"];
    $Object->accreditated = $formdata->accreditated;
    $Object->hours = $formdata->hours;
    $Object->hours_per_week = $formdata->hours_per_week;
    $Object->business_version = $formdata->business_version;
    $Object->promo_url = $formdata->promo_url;
    $Object->promo_lang = $formdata->promo_lang;
    $Object->subtitles_lang = $formdata->subtitles_lang;
    $Object->estimation_tools = $formdata->estimation_tools;
    $Object->proctoring_service = $formdata->proctoring_service;
    $Object->sessionid = $formdata->sessionid;
    $Object->teachers->teacher[0]->title = $formdata->t_title;
    $Object->teachers->teacher[0]->image = $formdata->t_image;
    $Object->teachers->teacher[0]->description = $formdata->t_description;
    $Object->transfers->courseTransfer[0]->institution_id = $formdata->institution_id;
    $Object->transfers->courseTransfer[0]->direction_id = $formdata->direction_id;
    if ($Object->external_courseid != '') {
        $Object->id = $Object->external_courseid;
    }
    unset($Object->external_courseid);
    unset($Object->internal_courseid);
    $Object_for_db->json = json_encode($Object);
    return $Object_for_db;
}

function boolen_convert($expression) {
    if ($expression == '0') {
        $expression = false;}
    if ($expression == '1'){
        $expression = true;}
    if ($expression == true) {
        $expression = '1';}
    if ($expression == false) {
        $expression = '0';}
    return $expression;
}

function get_obj_from_json($json, $internal_courseid, $id) {
    $obj = json_decode($json);
    $obj->external_courseid = $obj->id;
    $obj->internal_courseid = $internal_courseid;
    $obj->id = $id;
//    unset($obj->id);
    return $obj;
}

function  add_course($url, $jsonString) {
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => 'Content-type: application/json',
        CURLOPT_REFERER => 'https://mooc.vsu.ru/',
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => 1,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_CAINFO => '1023601560510.crt',
    CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => [
            json => $jsonString,
            ],
    ]);
    $resp = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($status != 201) {
        die("Error: call to URL $url failed with status $status, response $resp, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);
}

//function update_course($url, $course_id_ext, $jsonString) {
//    $curl = curl_init($url);
//    curl_setopt_array($curl, [
//        CURLOPT_RETURNTRANSFER => 1,
//        CURLOPT_HTTPHEADER => 'Content-type: application/json',
//        CURLOPT_REFERER => 'https://mooc.vsu.ru/',
//        CURLOPT_PUT => 1,
//        CURLOPT_POSTFIELDS => [
//            json => $jsonString
//        ]
//    ]);
//    $resp = curl_exec($curl);
//    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//    if ($status != 201) {
//        die("Error: call to URL $url failed with status $status, response $resp, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
//    }
//    curl_close($curl);
//    $response = json_decode($resp, true);
//}

function change_status_of_course($url, $course_id_ext) {
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_PUT => 1,
        CURLOPT_REFERER => 'https://mooc.vsu.ru/'
    ]);
    $json_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($status != 201) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    curl_close($curl);
}

function get_grade_status_course($url) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
    ]);
    $resp = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
}

function execute_portfolio($url, $reg_on_course_obj) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => 1,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_CAINFO => '1023601560510.crt',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => [
            json => $reg_on_course_obj
        ]
    ]);
    $resp = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
}

//function reg_on_course_obj() {
//    $reg_on_course_obj = new stdClass();
//    $reg_on_course_obj->courseId = ;
//    $reg_on_course_obj->sessionId = ;
//    $reg_on_course_obj->usiaId = ;
//    $reg_on_course_obj->enrollDate = ;
//    $reg_on_course_obj->sessionStart = ;
//    $reg_on_course_obj->sessionEnd = ;
//    return $reg_on_course_obj;
//}

//function reg_on_course_list() {
//    $reg_on_course_list = new stdClass();
//    $reg_on_course_list->courseId = ;
//    $reg_on_course_list->sessionId = ;
//    $reg_on_course_list->usiaId = ;
//    $reg_on_course_list->saced = ;
//    return $reg_on_course_list;
//}

//function reg_on_course_list_groupe() {
//    $reg_on_course_list_groupe = new stdClass();
//    $reg_on_course_list_groupe->courseId = ;
//    $reg_on_course_list_groupe->sessionId = ;
//    $reg_on_course_list_groupe->usiaId = ;
//    return $reg_on_course_list_groupe;
//}
//
//function con_reg_on_course_list(){
//    $con_reg_on_course_list = new stdClass();
//    return $con_reg_on_course_list;
//}
//
//function con_reg_on_course_list_groupe(){
//    $con_reg_on_course_list_groupe = new stdClass();
//    return $con_reg_on_course_list_groupe;
//}
//
//function check_reg_on_course_list(){
//    $check_reg_on_course_list = new stdClass();
//    $check_reg_on_course_list->courseId = ;
//    $check_reg_on_course_list->sessionId = ;
//    $check_reg_on_course_list->usiaId = ;
//    $check_reg_on_course_list->date = ;
//    $check_reg_on_course_list->rating = ;
//    $check_reg_on_course_list->progress = ;
//    $check_reg_on_course_list->proctored = ;
//    $check_reg_on_course_list->checkpointName = ;
//    $check_reg_on_course_list->checkpointId = ;
//    return $check_reg_on_course_list;
//}
//
//function ans_course_publ_obj(){
//    $ans_course_publ_obj = new stdClass();
//    $ans_course_publ_obj->usiaId = ;
//    $ans_course_publ_obj->date = ;
//    $ans_course_publ_obj->checkpointId = ;
//    $ans_course_publ_obj->saved = ;
//    return $ans_course_publ_obj;
//}
//
//function obj_publ_prog_study(){
//    $obj_publ_prog_study = new stdClass();
//    $obj_publ_prog_study->courseId = ;
//    $obj_publ_prog_study->sessionId = ;
//    $obj_publ_prog_study->usiaId = ;
//    $obj_publ_prog_study->progress = ;
//    return obj_publ_prog_study;
//}
//
//function obj_ans_on_req_publ_mass_prog_study(){
//    $obj_ans_on_req_publ_mass_prog_study = new stdClass();
//    $obj_ans_on_req_publ_mass_prog_study-> usiaId = ;
//    $obj_ans_on_req_publ_mass_prog_study-> courseId = ;
//    $obj_ans_on_req_publ_mass_prog_study-> sessionId = ;
//    $obj_ans_on_req_publ_mass_prog_study-> progress = ;
//    $obj_ans_on_req_publ_mass_prog_study-> saved = ;
//    return $obj_ans_on_req_publ_mass_prog_study;
//}
//
//function obj_req_on_publ_cert_in_portfolio(){
//    $obj_req_on_publ_cert_in_portfolio = new stdClass();
//    $obj_req_on_publ_cert_in_portfolio -> certNumber = ;
//    $obj_req_on_publ_cert_in_portfolio -> date = ;
//    $obj_req_on_publ_cert_in_portfolio -> studentName = ;
//    $obj_req_on_publ_cert_in_portfolio -> studentSurname = ;
//    $obj_req_on_publ_cert_in_portfolio -> studentPatronymicName = ;
//    $obj_req_on_publ_cert_in_portfolio -> userId = ;
//    $obj_req_on_publ_cert_in_portfolio -> courseId = ;
//    $obj_req_on_publ_cert_in_portfolio -> sessionId = ;
//    $obj_req_on_publ_cert_in_portfolio -> otherMetadata = ;
//    $obj_req_on_publ_cert_in_portfolio -> enrollAct = ;
//    $obj_req_on_publ_cert_in_portfolio -> enrollDate = ;
//    $obj_req_on_publ_cert_in_portfolio -> comlAct = ;
//    $obj_req_on_publ_cert_in_portfolio -> complDate = ;
//    $obj_req_on_publ_cert_in_portfolio -> IdentityDocument = ;
//    $obj_req_on_publ_cert_in_portfolio -> eduDoc = ;
//    return $obj_req_on_publ_cert_in_portfolio;
//}
//
//function obj_ans_on_req_read_cert(){
//    $obj_ans_on_req_read_cert = new stdClass();
//    $obj_ans_on_req_read_cert -> certId = ;
//    $obj_ans_on_req_read_cert -> certNumber = ;
//    $obj_ans_on_req_read_cert -> date = ;
//    $obj_ans_on_req_read_cert -> courseName = ;
//    $obj_ans_on_req_read_cert -> studentName = ;
//    $obj_ans_on_req_read_cert -> studentSurname = ;
//    $obj_ans_on_req_read_cert -> studentPatronymicName = ;
//    $obj_ans_on_req_read_cert -> userId = ;
//    $obj_ans_on_req_read_cert -> courseId = ;
//    $obj_ans_on_req_read_cert -> sessionId = ;
//    $obj_ans_on_req_read_cert -> otherMetadata = ;
//    $obj_ans_on_req_read_cert -> enrollAct = ;
//    $obj_ans_on_req_read_cert -> enrollDate = ;
//    $obj_ans_on_req_read_cert -> comlAct = ;
//    $obj_ans_on_req_read_cert -> complDate = ;
//    $obj_ans_on_req_read_cert -> status = ;
//    return $obj_ans_on_req_read_cert;
//}