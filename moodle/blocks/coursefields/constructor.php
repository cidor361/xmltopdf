<?php
class FieldDB {
    static function createField($courseid, $parentid, $title, $institution, $duration, $language, $cert, $business_version) {
        $object = new stdClass();
        $object->courseid = $courseid;
        $object->partnerid = $parentid;
        $object->title = $title;
        $object->started_at = '';
        $object->finished_at = '';
        $object->enrollment_finished_at = '';
        $object->image = '';
        $object->description = '';
        $object->competences = '';
        $object->requirements = '';
        $object->content = '';
        $object->external_url = '';
        $object->direction = '';
        $object->institution = $institution;
        $object->duration = $duration;
        $object->lectures = '';
        $object->language = $language;
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
        $object->sessionid = ''
        return $object;
//TODO: сверить с регламентом
    }
}