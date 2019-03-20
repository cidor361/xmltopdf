<?php
function createMainField($courseid, $parentid, $title, $description,
                        $external_url, $direction, $institution,
                            $duration, $cert, $business_version) {
    $object = new stdClass();
    $object->courseid = $courseid;
    $object->partnerid = $parentid;
    $object->title = $title;
    $object->started_at = '';
    $object->finished_at = '';
    $object->enrollment_finished_at = '';
    $object->image = '';
    $object->description = $description;
    $object->competences = '';
    $object->requirements = '';
    $object->content = '';
    $object->external_url = $external_url;
    $object->direction = $direction;
    $object->institution = $institution;
    $object->duration = $duration;
    $object->lectures = '';
    $object->language = '';
    $object->cert = $cert;
    $object->visitors = '';
    $object->teachers = '';
    $object->transfers = '';
    $object->results = '';
    $object->hours = '';
    $object->hours_per_week = '';
    $object->business_version = $business_version;
    $object->promo_url = '';
    $object->promo_lang = '';
    $object->subtitles_lang = '';
    $object->estimation_tools = '';
    $object->proctoring_service = '';
    $object->sessionid = '';
    return $object;
//TODO: сверить с регламентом
}
function createTeacherField($courseid, $title){
    $teacherObject = new stdClass();
    $teacherObject->courseid = $courseid;
    $teacherObject->title = $title;
    $teacherObject->image = '';
    $teacherObject->description = '';
    return $teacherObject;
}
function createCoursetransferField($courseid, $institution_id, $direction_id){
    $coursetransferObject = new stdClass();
    $coursetransferObject->courseid = $courseid;
    $coursetransferObject->institution_id = $institution_id;
    $coursetransferObject->direction_id = $direction_id;
    return $coursetransferObject;
}
function fillFields($object, $courseobject) {
    $object->courseid = $courseobject->id;
    $object->title = $courseobject->fullname;
    $object->started_at = $courseobject->startdate;
    $object->finished_at = $courseobject->enddate;
    $object->enrollment_finished_at = '';
    $object->image = '';
    $object->description = $courseobject->summary;
    $object->competences = '';
    $object->requirements = '';
    $object->content = '';
    $object->external_url = $external_url;
    $object->direction = $direction;
    $object->institution = $institution;
    $object->duration = $duration;
    $object->lectures = '';
    if($courseobject->lang == null){
        $object->language = 'ru';
    } else {
        $object->language = $courseobject->lang;
    }
    $object->cert = $cert;
    $object->visitors = '';
    $object->teachers = '';
    $object->transfers = '';
    $object->results = '';
    $object->hours = '';
    $object->hours_per_week = '';
    $object->business_version = $business_version;
    $object->promo_url = '';
    $object->promo_lang = '';
    $object->subtitles_lang = '';
    $object->estimation_tools = '';
    $object->proctoring_service = '';
    $object->sessionid = '';
    return $object;
}