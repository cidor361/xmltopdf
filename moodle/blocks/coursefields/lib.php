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
 * @copyright  2020 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function get_course_info($course, $USER, $info=null) {

    // Get course info from standart table
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

    // Old function for removing some char
    $string = strip_tags($string, '');
    $string = str_replace("\n", ' ', $string);
    $string = str_replace("\r", '', $string);
    return $string;
}


function get_json_for_sending($toform, $info, $external_courseid = null) {

    // Convert stdClass to json string and remove empty fields
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
    $teachers->t_image = $toform->t_image;
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


function add_course($json, $login_password, $info) {

    // Upload course informations
    $login_password = base64_encode($login_password);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $info['address'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_SSLCERT => $info['certfile'],
        CURLOPT_SSLKEY => $info['keyfile'],
        CURLOPT_HTTPHEADER => array(
            "Referer: https://mooc.vsu.ru/",
            "Content-Type: application/json",
            "Authorization: Basic $login_password"
        ),
    ));


    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

/*function update_ext_course($url, $jsonString, $login_password) {

    // Upload updated course information
    $login_password = base64_encode($login_password);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $info['get_grade_status'].$external_courseid);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: Basic $login_password"
    ));


    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return var_dump($status).'</br>'.var_dump($response);
    curl_setopt($curl, CURLOPT_URL, $info['get_grade_status'].$external_courseid);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: Basic $login_password"
    ));


    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return var_dump($status).'</br>'.var_dump($response);
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
}*/

function update_ext_course($json, $login_password, $info) {

    // Upload updated course information
    $login_password = base64_encode($login_password);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $info['address'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_SSLCERT => $info['certfile'],
        CURLOPT_SSLKEY => $info['keyfile'],
        CURLOPT_HTTPHEADER => array(
            "Referer: https://mooc.vsu.ru/",
            "Content-Type: application/json",
            "Authorization: Basic $login_password"
        ),
    ));


    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return var_dump($status).'</br>'.var_dump($response);

}

function get_grade_status_course($external_courseid, $login_password, $info) {

    // Get course grade status
    $login_password = base64_encode($login_password);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $info['get_grade_status'].$external_courseid);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: Basic $login_password"
    ));

    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return var_dump($response);
}


function create_enrol_object($ext_courseid, $usiaid, $course) {

    // Create enroll object for enrol_on_course() function
    $enroll_on_course = new stdClass();
    $enroll_on_course->courseId = $ext_courseid;
    $enroll_on_course->sessionId = '1';
    $enroll_on_course->usiaId = $usiaid;
    $enroll_on_course->enrollDate = date("Y-m-d", $course->startdate)."T".date("H:i:sO", $course->startdate);  //TODO: сделать дату зачисления на курс
    $enroll_on_course->sessionStart = date("Y-m-d", $course->startdate)."T".date("H:i:sO", $course->startdate);
    $enroll_on_course->sessionEnd = date("Y-m-d", $course->enddate)."T".date("H:i:sO", $course->enddate);
    return $enroll_on_course;
}


function enrol_on_course($ext_courseid, $course, $usiaid,
                                $info) {  //TODO: получение ЕСИА id

    //  Send enroll information
    $curl = curl_init();
    if (is_array($usiaid)){
        curl_setopt($curl, CURLOPT_URL, $info['group_enroll_on_course']);
        $list = array();
        $i = 0;
        foreach ($usiaid as $user) {
            $list[$i] = create_enrol_object($ext_courseid, $user, $course);
            $i = $i + 1;
        }

        $json = json_encode($list, JSON_UNESCAPED_UNICODE);

    } else {
        curl_setopt($curl, CURLOPT_URL, $info['enroll_on_course']);
        $registration_object = create_enrol_object($ext_courseid, $usiaid, $course);
        $json = json_encode($registration_object, JSON_UNESCAPED_UNICODE);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));

    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return var_dump($status).'</br>'.var_dump($response).'</br>'.var_dump($json);

}


function create_unenroll_checkenroll_object($ext_courseid, $usiaid) {

    // Create object for unenroll_on_course() and checkenroll_on_course() functions
    $cancel_registration_object = new stdClass();
    $cancel_registration_object->courseId = $ext_courseid;
    $cancel_registration_object->sessionId = '1';
    $cancel_registration_object->usiaId = $usiaid;
    return $cancel_registration_object;
}


function unenroll_on_course($ext_courseid, $usiaid, $info) {

    // Send unenroll information
    $curl = curl_init();
    if (is_array($usiaid)){
        curl_setopt($curl, CURLOPT_URL, $info['group_unenroll_on_course']);
        $list = array();
        $i = 0;
        foreach ($usiaid as $user) {
            $list[$i] = create_unenroll_checkenroll_object($ext_courseid, $user);
            $i = $i + 1;
        }

        $json = json_encode($list, JSON_UNESCAPED_UNICODE);

    } else {
        curl_setopt($curl, CURLOPT_URL, $info['unenroll_on_course']);
        $registration_object = create_unenroll_checkenroll_object($ext_courseid, $usiaid, $course);
        $json = json_encode($registration_object, JSON_UNESCAPED_UNICODE);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));

    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return var_dump($status).'</br>'.var_dump($response).'</br>'.var_dump($json);
}


function checkenroll_on_course($ext_courseid, $usiaid, $info) {

    // Check if user has enrolled to course
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $info['checkenroll_on_course']);
    $registration_object = create_unenroll_checkenroll_object($ext_courseid, $usiaid, $course);
    $json = json_encode($registration_object, JSON_UNESCAPED_UNICODE);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));

    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return var_dump($status).'</br>'.var_dump($response).'</br>'.var_dump($json);
}


function create_result_object($ext_courseid, $usiaid, $module) {

    // Create object for send_result() function
    $result_object = new stdClass();
    $result_object->courseId = $ext_courseid;
    $result_object->sessionId = '1';
    $result_object->usiaId = $usiaid;
    $result_object->date = '';      //TODO: информация по модулю
    $result_object->rating = '';        //TODO if (exist(result)) {result} else {null}
    $result_object->progress = '';      //TODO: прогресс курса
    //$result_object->proctored = '';       //there is no proctoring system
    $result_object->checkpointName = '';        //TODO: modulname
    $result_object->checkpointId = '';          //TODO: moduleid
    return $result_object;
}


function send_result($ext_courseid, $usiaid, $module, $info) {

    // Send result from course module
    $curl = curl_init();
    if (is_array($usiaid)){
        curl_setopt($curl, CURLOPT_URL, $info['send_results']);
        $list = array();
        $i = 0;
        foreach ($usiaid as $user) {
            $list[$i] = create_result_object($ext_courseid, $user, $module);
            $i = $i + 1;
        }

        $json = json_encode($list, JSON_UNESCAPED_UNICODE);

    } else {
        curl_setopt($curl, CURLOPT_URL, $info['unenroll_on_course']);
        $result_object = create_result_object($ext_courseid, $usiaid, $module);
        $json = json_encode($result_object, JSON_UNESCAPED_UNICODE);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));

    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return var_dump($status).'</br>'.var_dump($response).'</br>'.var_dump($json);
}


function create_progress_object($ext_courseid, $usiaid, $progress, $info) {

    //Create object for send_progress() function
    $progress_object = new stdClass();
    $progress_object->courseId = $ext_courseid;
    $progress_object->sessionId = '1';
    $progress_object->usiaId = $usiaid;
    $progress_object->progress = $progress;    //TODO: make progress
    return $progress_object;
}


function send_progress($ext_courseid, $usiaid, $progress, $info) {

    // Send course progress
    $curl = curl_init();
    if (is_array($usiaid)){
        curl_setopt($curl, CURLOPT_URL, $info['send_progresses']);
        $list = array();
        $i = 0;
        foreach ($usiaid as $user) {
            $list[$i] = create_progress_object($ext_courseid, $user, $module);
            $i = $i + 1;
        }

        $json = json_encode($list, JSON_UNESCAPED_UNICODE);

    } else {
        curl_setopt($curl, CURLOPT_URL, $info['send_progress']);
        $progress_object = create_progress_object($ext_courseid, $usiaid, $module);
        $json = json_encode($progress_object, JSON_UNESCAPED_UNICODE);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 0);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_SSLCERT, $info['certfile']);
    curl_setopt($curl, CURLOPT_SSLKEY, $info['keyfile']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));

    $response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return var_dump($status).'</br>'.var_dump($response).'</br>'.var_dump($json);
}


function create_mark_object($ext_courseid, $userid) {

    // Create object for send_mark() function
    $mark_object = new stdClass();

    $user_data = '"user_ids":[';         //TODO: need optimisation
    foreach ($userid as $user) {
        $user_data = $user_data.'"'.$user.'",';
    }
    $user_data = substr($user_data,0,-1);
    $user_data = $user_data.']';

    $mark_object->user_ids = $user_data;
    $mark_object->course_id = $ext_courseid;
    $mark_object->session_id = '1';
    return $mark_object;
}
