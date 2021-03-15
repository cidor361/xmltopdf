<?php
function get_user_field_ids() {
    global $DB;
    
    $sql = "SELECT id, shortname 
            FROM mdl_user_info_field
            WHERE (shortname = 'fac') OR
                  (shortname = 'year') OR
                  (shortname = 'stform') OR
                  (shortname = 'level') OR
                  (shortname = 'naprspec');";
    $results = $DB->get_records_sql($sql);

    $ids = array();
    foreach ($results as $result) {
        $name = $result->shortname;
        $ids[$name] = $result->id;
    }

    return $ids;
}

function get_facultet_names($ids) {
    global $DB;
    
    $field_id = $ids['fac'];
    
    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);
    $i = 0;
    $facultets = array();
    foreach ($results as $result) {
        if (($result->data != '') && ($result->data != null)) {
            $facultets[$i] = $result->data;
            $i++;
        }
    }

    $facultets = sort_array($facultets);
    
    return $facultets;
}

function get_num_course_name($ids) {
    global $DB;

    $field_id = $ids['year'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $nums_course = array();
    foreach ($results as $result) {
        if (($result->data != '') && ($result->data != null)) {
            $nums_course[$i] = $result->data;
            $i++;
        }
    }

    $nums_course = sort_array($nums_course);

    return $nums_course;
}

function get_edu_forms_name($ids) {
    global $DB;

    $field_id = $ids['stform'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_forms = array();
    foreach ($results as $result) {
        if (($result->data != '') && ($result->data != null)) {
            $edu_forms[$i] = $result->data;
            $i++;
        }
    }

    $edu_forms = sort_array($edu_forms);

    return $edu_forms;
}

function get_edu_level_name($ids) {
    global $DB;

    $field_id = $ids['level'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_levels = array();
    foreach ($results as $result) {
        if (($result->data != '') && ($result->data != null)) {
            $edu_levels[$i] = $result->data;
            $i++;
        }
    }

    $edu_levels = sort_array($edu_levels);

    return $edu_levels;
}

function get_edu_specialites_name($ids) {
    global $DB;

    $field_id = $ids['naprspec'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_specialites = array();
    foreach ($results as $result) {
        if (($result->data != '') && ($result->data != null)) {
            $edu_specialites[$i] = $result->data;
            $i++;
        }
    }

    $edu_specialites = sort_array($edu_specialites);

    return $edu_specialites;
}

function get_edu_specialites_fac($ids) {
    global $DB;
    
    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$ids['fac']."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_specialites = array();
    foreach ($results as $result) {
        if ($result->data != '' and $result->data != null) {
            $edu_specialites[$i] = $result->data;
        }
        $i++;
    }

    $edu_specialites = sort_array($edu_specialites);

    return $edu_specialites;
}

function search_vsu_fields_users($ids, $fields) {    //TODO: поправить в соответствии с формами
    global $DB;
    
    //Get list of user
    //$field_ids - field ids (example 1 - facultet or 2 - year)
    //$fields - field value (example 1 - Физический факультет or 2 - 2020)

    $sql = "select userid from mdl_user_info_data where fieldid = '".$ids['fac']."' and data = '".$fields->fac."' and userid in
                (select userid from mdl_user_info_data where fieldid = '".$ids['naprspec']."' and data = '".$fields->naprspec."' and userid in 
                    (select userid from mdl_user_info_data where fieldid = '".$ids['year']."' and data = '".$fields->year."' and userid in
                        (select userid from mdl_user_info_data where fieldid = '".$ids['stform']."' and data = '".$fields->stform."' and userid in
                            (select userid from mdl_user_info_data where fieldid = '".$ids['level']."' and data = '".$fields->level."'))));";
    $user_ids = $DB->get_records_sql($sql);
    
    $users = new stdClass();
    $i = 0;
    foreach ($user_ids as $user_id) {
        $id = $user_id->userid;
        $users->$i = $DB->get_record('user', array('id' => $id), $fields = 'id,firstname,lastname');
        $i++;
    }
    
    return $users;
}

function sort_array($array) {
    for ($i=0; $i < count($array); $i++) {
        $sortkey[$i]=$array[$i]['price'];
    }

    asort($sortkey); //по возрастанию,
    //arsort($sortkey); //по убыванию

    foreach ($sortkey as $key => $key) {
        $sorted[]=$array[$key];
    }

    return $sorted;
}

function prepare_data_one($fromform, $firstdata) {
    $data = new stdClass();
    $data->fac = $firstdata->facultets[$fromform->fac];
    $data->naprspec = $firstdata->edu_specialites[$fromform->naprspec];
    $data->year = $firstdata->num_course[$fromform->year];
    $data->stform = $firstdata->edu_forms[$fromform->stform];
    $data->level = $firstdata->edu_level[$fromform->level];

    return $data;
}

function enrol_user_manual($courseid, $id, $roleid=5, $duration=0, $method='manual') {

    global $DB;
    //Get enroll instance:
    $sql = "SELECT id FROM mdl_enrol WHERE courseid='".$courseid."' AND enrol='".$method."';";
    $result = $DB->get_records_sql($sql);
    if(!$result){
        ///Not enrol associated (this shouldn't happen and means you have an error in your moodle database)
    }
    foreach ($result as $unit){
        $idenrol = $unit->id;
    }

    //Get the context
    $sql = "SELECT id FROM mdl_context WHERE contextlevel='50' AND instanceid='".$courseid."';"; ///contextlevel = 50 means course in moodle
    $result = $DB->get_records_sql($sql);
    if(!$result){
        ///Again, weird error, shouldnt happen to you
    }
    foreach ($result as $unit){
        $idcontext = $unit->id;
    }


    //Get variables from moodle. Here is were the enrolment begins:
    $time = time();
    $ntime = $time + 60*60*24*$duration; //How long will it last enroled $duration = days, this can be 0 for unlimited.
    $sql = "INSERT INTO mdl_user_enrolments (status, enrolid, userid, timestart, timeend, timecreated, timemodified)
VALUES (0, $idenrol, $id, '$time', '$ntime', '$time', '$time')";
    if ($DB->execute($sql) === TRUE) {
    } else {
        ///Manage sql error
    }

    $sql = "INSERT INTO mdl_role_assignments (roleid, contextid, userid, timemodified)
VALUES ($roleid, $idcontext, '$id', '$time')";
    if ($DB->execute($sql) === TRUE) {
        return true;
    } else {
        //Manage errors
    }
}