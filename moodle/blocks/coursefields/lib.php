<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    block_coursefields
 * @category   block
 * @copyright  2008 Kim Bloggs
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function get_course_info($course, $USER, $info=null) {
    $toform = new stdClass();
    $toform->title = $course->fullname;
    $toform->started_at = gmdate("Y-m-d", (int)$course->startdate);
    $toform->finished_at = gmdate("Y-m-d", (int)$course->enddate);
    $toform->description = strip_html_tags($course->summary);
    $toform->external_url = $info['courselink'] . $course->id;
    $toform->institution = $info['institution'];
    $toform->language = 'ru';
    $toform->business_version = 1;
    $toform->teachers = array();
    $toform->teachers[0]->display_name = $USER->firstname . ' ' . $USER->lastname;
    return $toform;
}

function strip_html_tags($string) {
    $string = strip_tags($string, '');
    $string = str_replace("\n", ' ', $string);
    $string = str_replace("\r", '', $string);
    return $string;
}

function add_tags_competences($string) {
    $string = str_replace('\n', '</p><p>', $string);
    $string = '<p>' . $string . '</p>';
    return $string;
}

function strip_tags_competences($string) {
    $string = str_replace('</p><p>', '\n', $string);
    $string = strip_tags($string, '');
    return $string;
}

function add_data_for_db($Object, $internal_courseid, $external_courseid, $id = null) {
    $Object_for_db = new stdClass();
    $Object_for_db->id = $id;
    $Object_for_db->json = json_encode($Object, JSON_UNESCAPED_UNICODE);
    $Object_for_db->internal_courseid = $internal_courseid;
    $Object_for_db->external_courseid = $external_courseid;
    if (!empty($id)) {
        $Object_for_db->id;
    };
    return $Object_for_db;
}

function get_json_for_sending($toform, $info, $external_courseid = null) {
    $duration = $toform->duration;
    $toform->duration = new stdClass();
    $toform->duration->code = "week";
    $toform->duration->value = $duration;
    $toform->direction = array($toform->direction);
    $toform->institution = $info['institution'];
    $toform->cert = filter_var($toform->cert, FILTER_VALIDATE_BOOLEAN);
    unset($toform->submitbutton);
    $json = new stdClass();
    $json->partnerId = $info['partnerid'];
    $json->package = new stdClass();
    $json->package->items = array();
    $teachers = new stdClass();
    $teachers->t_title = $toform->t_title;
    $teachers->t_image = $toform->t_title;
    $teachers->t_description = $toform->t_description;
    unset($toform->t_title);
    unset($toform->t_image);
    unset($toform->t_description);
    if ($toform->image == '') {
        unset($toform->image);
    }
    if ($toform->lectures == '') {
        unset($toform->lectures);
    }
    if ($toform->results == '') {
        unset($toform->results);
    }
    if ($toform->hours == '') {
        unset($toform->hours);
    }
    if ($toform->hours_per_week == '') {
        unset($toform->hours_per_week);
    }
    if ($toform->business_version == '') {
        $toform->business_version = 1;
    }
    $toform->sessionid = '';
    if ($external_courseid != null) {
        $toform->id = $external_courseid;
    }
    $json->package->items[0] = $toform;
    $json->package->items[0]->teachers = array();
    $json->package->items[0]->teachers[0]->display_name = $teachers->t_title;
    if($teachers->t_image != '') {
        $json->package->items[0]->teachers[0]->image = $teachers->t_image;
    }
    if($teachers->t_description != '') {
        $json->package->items[0]->teachers[0]->description = $teachers->t_description;
    }
    $json = json_encode($json, JSON_UNESCAPED_UNICODE);
    $json = str_replace('\\', '', $json);
    $json = strip_html_tags($json);
    return $json;
}

function add_course($url, $json, $login_password) {
    $login_password = base64_encode($login_password);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "$json",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Basic $login_password"
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function update_ext_course($url, $jsonString, $login_password) {
    $login_password = base64_encode($login_password);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $jsonString,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Basic $login_password"
        ),
    ));
    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($status == 200) {
        return get_string('seccess_update', 'block_coursefields'); //TODO: make string!
    } else {
        die("Error: call to URL $url failed with status $status, response $response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
}

function get_grade_status_course($url, $external_courseid, $login_password) {
    $login_password = base64_encode($login_password);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url . $external_courseid,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic $login_password"
        ),
    ));
    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($status == 200) {
        die("Error: call to URL $url failed with status $status, response $response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
    return $response;
}
