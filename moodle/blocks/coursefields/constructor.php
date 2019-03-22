<?php
function createMainField($course, $parentid, $duration) {
    $object = new stdClass();
    $object->courseid = $course->id;
    $object->partnerid = $parentid;
    $object->title = $course->fullname;
    $object->started_at = $course->startdate;
    $object->finished_at = $course->enddate;
    $object->enrollment_finished_at = '';
    $object->image = '';
    $object->description = $course->summary;
    $object->competences = '';
    $object->requirements = '';
    $object->content = '';
    $object->external_url = '';
    $object->direction = '';
    $object->institution = '';
    $object->duration = $duration;
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
function createTeacherField($courseid){
    $teacherObject = new stdClass();
    $teacherObject->courseid = $courseid;
    $teacherObject->title = '';
    $teacherObject->image = '';
    $teacherObject->description = '';
    return $teacherObject;
}
function createCoursetransferField($courseid){
    $coursetransferObject = new stdClass();
    $coursetransferObject->courseid = $courseid;
    $coursetransferObject->institution_id = '';
    $coursetransferObject->direction_id = '';
    return $coursetransferObject;
}