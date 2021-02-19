<?php

function get_extra_field_ids() {
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

function get_facultets($ids) {
    global $DB;
    
    $field_id = $ids['fac'];
    
    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);
    $i = 0;
    $facultets = array();
    foreach ($results as $result) {
        if ($result->data != '') {
            $facultets[$i] = $result->data;
            $i++;
        }
    }

    //$facultets = sort_array($facultets);
    
    return $facultets;
}

function get_num_course($ids) {
    global $DB;

    $field_id = $ids['year'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $nums_course = array();
    foreach ($results as $result) {
        if ($result->data != '') {
            $nums_course[$i] = $result->data;
            $i++;
        }
    }

    //$nums_course = sort_array($nums_course);

    return $nums_course;
}

function get_edu_forms($ids) {
    global $DB;

    $field_id = $ids['stform'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_forms = array();
    foreach ($results as $result) {
        if ($result->data != '') {
            $edu_forms[$i] = $result->data;
        }
        $i++;
    }

    //$edu_forms = sort_array($edu_forms);

    return $edu_forms;
}

function get_edu_level($ids) {
    global $DB;

    $field_id = $ids['level'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_levels = array();
    foreach ($results as $result) {
        if ($result->data != '') {
            $edu_levels[$i] = $result->data;
        }
        $i++;
    }

    //$edu_levels = sort_array($edu_levels);

    return $edu_levels;
}

function get_edu_specialites($ids) {
    global $DB;

    $field_id = $ids['naprspec'];

    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $results = $DB->get_records_sql($sql);

    $i = 0;
    $edu_specialites = array();
    foreach ($results as $result) {
        if ($result->data != '') {
            $edu_specialites[$i] = $result->data;
        }
        $i++;
    }

    //$edu_specialites = sort_array($edu_specialites);

    return $edu_specialites ;
}

function get_edu_specialites_with_fac($field_ids) {
    global $DB;
    
    $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '".$field_id."';";
    $result = $DB->get_records_sql($sql);
    
    return (array)$result;
}

function search_vsu_users($field_ids, $fields) {    //TODO: поправить в соответствии с формами
    global $DB;
    
    //Get list of user
    //$field_ids - field ids (example 1 - facultet or 2 - year)
    //$fields - field value (example 1 - Физический факультет or 2 - 2020)
        
    $sql = "select userid from mdl_user_info_data where fieldid = ".$field_ids[0]." and data = ".$fields[0]." and userid in
                (select userid from mdl_user_info_data where fieldid = ".$field_ids[1]." and data = ".$fields[1]." and userid in 
                    (select userid from mdl_user_info_data where fieldid = ".$field_ids[2]." and data = ".$fields[2]." and userid in
                        (select userid from mdl_user_info_data where fieldid = ".$field_ids[3]." and data = ".$fields[3]." and userid in
                            (select userid from mdl_user_info_data where fieldid = ".$field_ids[4]." and data = ".$fields[4]."))));";
    $user_ids = $DB->get_records_sql($sql);
    
    $users = new sdtClass();
    $i = 0;
    foreach ($user_ids as $user_id) {
        $users[$i] = $DB->get_record('user', array('id'=>$user_id->id), $sort='', 
                                    $fields='id,firstname,lastname');
        $i++;
    }
    
    return $users;
}


function check_enrolment($courseid, $userid, $roleid = '5', $enrolmethod = 'manual'){
   
       global $DB;
       
       $user = $DB->get_record('user', array('id' => $userid, 'deleted' => 0), '*', MUST_EXIST);
       $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
       $context = context_course::instance($course->id);
       if (!is_enrolled($context, $user)) {
         $enrol = enrol_get_plugin($enrolmethod);
         if ($enrol === null) {
            return false;
         }
        $instances = enrol_get_instances($course->id, true);
        $manualinstance = null;
        foreach ($instances as $instance) {
            if ($instance->name == $enrolmethod) {
                $manualinstance = $instance;
                break;
            }
        }
        if ($manualinstance !== null) {
            $instanceid = $enrol->add_default_instance($course);
            if ($instanceid === null) {
                $instanceid = $enrol->add_instance($course);
            }
            $instance = $DB->get_record('enrol', array('id' => $instanceid));
        }
        $enrol->enrol_user($instance, $userid, $roleid);
    }
    return true;
}

function sort_array($array) {
    for ($i=0; $i < count($array); $i++) {
        $sortkey[$i]=$array[$i]['price'];
    }

    asort($sortkey);//по возрастанию, arsort($sortkey) - по убыванию

    foreach ($sortkey as $key => $key) {
        $sorted[]=$array[$key];
    }
}