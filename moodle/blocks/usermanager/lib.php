<?php
function get_user_field_ids() {
    /*
     * fac - Факультет //Физический факультет
     * year - Курс //4
     * stform - Форма обучения //Очная
     * level - Ступень //Бакалавр
     * naprspec - Код и наименование направления (специальности) //09.03.01 Информатика и вычислительная техника
     * naprspec2 - Наименование направления (специальности) //Информатика и вычислительная техника
     * specialityCode - Код направления (специальности) //09.03.01
     * profile - Профиль (специализация) //Вычислительные машины, комплексы, системы и сети (ФГОС3+)
    */

    global $DB;
    
    $sql = "SELECT id, shortname 
            FROM mdl_user_info_field
            WHERE (shortname = 'fac') OR
                  (shortname = 'year') OR
                  (shortname = 'stform') OR
                  (shortname = 'level') OR
                  (shortname = 'naprspec') OR
                  (shortname = 'specialityCode') OR
                  (shortname = 'profile') OR
                  (shortname = 'naprspec2');";
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

function search_vsu_fields_users($ids, $fields) {
    global $DB;
    
    //Get list of user
    //$field_ids - field ids (example 1 - facultet or 2 - year)
    //$fields - field value (example 1 - Физический факультет or 2 - 2020)
    /*
     * 7 -
     * 11 -
     * 12 -
     * 16 - fac (facultet; example 'Физический факультет')
     * 19 - stat (edu status; example эучится')
     * 21 -
     */

    $sql = "select userid from mdl_user_info_data where fieldid='19' and data='учится' and userid in
                (select userid from mdl_user_info_data where fieldid = '".$ids['fac']."' and data = '".$fields->fac."' and userid in
                    (select userid from mdl_user_info_data where fieldid = '".$ids['naprspec']."' and data = '".$fields->naprspec."' and userid in 
                        (select userid from mdl_user_info_data where fieldid = '".$ids['year']."' and data = '".$fields->year."' and userid in
                            (select userid from mdl_user_info_data where fieldid = '".$ids['stform']."' and data = '".$fields->stform."' and userid in
                                (select userid from mdl_user_info_data where fieldid = '".$ids['level']."' and data = '".$fields->level."')))));";
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


function enrol_user_manual($courseid, $userid, $group_id, $roleid=5, $duration=0, $method='manual') {

    global $DB;

    //Check if user already enrolled
    $context = context_course::instance($courseid);
    if (is_enrolled($context, $userid, '', true)) {
        return true;
    }

    //Get enroll instance:
    $sql = "SELECT id FROM mdl_enrol WHERE courseid='".$courseid."' AND enrol='".$method."';";
    $result = $DB->get_records_sql($sql);
    if(!$result){
        ///Not enrol associated (this shouldn't happen and means you have an error in your moodle database)
        return false;
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
    //$ntime = $time + 60*60*24*$duration; //How long will it last enroled $duration = days, this can be 0 for unlimited.
    $ntime = 0;
    $sql = "INSERT INTO mdl_user_enrolments (status, enrolid, userid, timestart, timeend, timecreated, timemodified)
VALUES (0, $idenrol, $userid, '$time', '$ntime', '$time', '$time')";
    if ($DB->execute($sql) === TRUE) {
    } else {
        ///Manage sql error
        return false;
    }

    $sql = "INSERT INTO mdl_role_assignments (roleid, contextid, userid, timemodified)
VALUES ($roleid, $idcontext, '$userid', '$time')";
    if ($DB->execute($sql) === TRUE) {
        //return true;
    } else {
        //Manage errors
        return false;
    }

    //add users into group
    if (groups_add_member($group_id, $userid)) {
        return true;
    } else {
        return false;
    }
}

function search_vsu_fields_users_per_disciplin($ids, $disciplin) {
    global $DB;

    //Get list of user
    //$field_ids - field ids (example 1 - facultet or 2 - year)
    //$fields - field value (example 1 - Физический факультет or 2 - 2020)
    /*
     * 7 -
     * 11 -
     * 12 -
     * 16 - fac (facultet; example 'Физический факультет')
     * 19 - stat (edu status; example эучится')
     * 21 -
     */

    $sql = "select userid from mdl_user_info_data where fieldid='19' and data='учится' and userid in
                (select userid from mdl_user_info_data where fieldid = '".$ids['level']."' and data = '".$disciplin->step."' and userid in
                    (select userid from mdl_user_info_data where fieldid = '".$ids['specialityCode']."' and data = '".$disciplin->speciality_code."' and userid in 
                        (select userid from mdl_user_info_data where fieldid = '".$ids['naprspec2']."' and data = '".$disciplin->speciality."' and userid in
                            (select userid from mdl_user_info_data where fieldid = '".$ids['stform']."' and data = '".$disciplin->st_form."' and userid in
                                (select userid from mdl_user_info_data where fieldid = '".$ids['profile']."' and data = '".$disciplin->specialisation."')))));";
    $user_ids = $DB->get_records_sql($sql);

    $users = new stdClass();

    foreach ($user_ids as $user_id) {
        $id = $user_id->userid;
        $users->{$id} = $DB->get_record('user', array('id' => $id), $disciplin = 'id,firstname,lastname');
    }

    return $users;
}

function search_vsu_fields_users_per_disciplin_without_specialisation($ids, $disciplin) {
    global $DB;

    $sql = "select userid from mdl_user_info_data where fieldid='19' and data='учится' and userid in
                (select userid from mdl_user_info_data where fieldid = '".$ids['level']."' and data = '".$disciplin->step."' and userid in
                    (select userid from mdl_user_info_data where fieldid = '".$ids['specialityCode']."' and data = '".$disciplin->speciality_code."' and userid in 
                            (select userid from mdl_user_info_data where fieldid = '".$ids['stform']."' and data = '".$disciplin->st_form."' and userid in
                                (select userid from mdl_user_info_data where fieldid = '".$ids['profile']."' and data = '".$disciplin->specialisation."'))));";
    $user_ids = $DB->get_records_sql($sql);

    $users = new stdClass();

    foreach ($user_ids as $user_id) {
        $id = $user_id->userid;
        $users->{$id} = $DB->get_record('user', array('id' => $id), $disciplin = 'id,firstname,lastname');
    }

    return $users;
}

function get_semestr_of_subject_oci_old($conn, $course) {
    global $DB;

    $rows = $DB->get_records_sql("SELECT * FROM {block_vsucourse_new} WHERE cid = '".$course->id."' and status = '0'");

    $result = new stdClass();

    foreach($rows as $row) {
        if ($row->specialisation == ""){
            $row->specialisation = '-';
        }
        $sql = '';
        if ($row->specialisation == "-") {
            $sql = "select * from contingent.moodle_subject_view WHERE 
							SUBJ_CODE = '" . $row->subj_code . "' and 
							SUBJ_NAME = '" . $row->subj_name . "' and
							ST_FORM = '" . $row->st_form . "' and
							faculty = '" . $row->faculty . "' 
							
							and STUDY_YEAR = (select max(STUDY_YEAR) from contingent.moodle_subject_view WHERE 
												SUBJ_CODE = '" . $row->subj_code . "' and 
												SUBJ_NAME = '" . $row->subj_name . "' and
												ST_FORM = '" . $row->st_form . "' and
												faculty = '" . $row->faculty . "' 
												
							)
							";
        } else {
            $sql = "select * from contingent.moodle_subject_view WHERE 
							SUBJ_CODE = '" . $row->subj_code . "' and 
							SUBJ_NAME = '" . $row->subj_name . "' and
							ST_FORM = '" . $row->st_form . "' and
							faculty = '" . $row->faculty . "' and
							SPECIALISATION = '" . $row->specialisation . "'
							and STUDY_YEAR = (select max(STUDY_YEAR) from contingent.moodle_subject_view WHERE 
												SUBJ_CODE = '" . $row->subj_code . "' and 
												SUBJ_NAME = '" . $row->subj_name . "' and
												ST_FORM = '" . $row->st_form . "' and
												faculty = '" . $row->faculty . "' and
												SPECIALISATION = '" . $row->specialisation . "'
							)
							";

        }

        $stid = oci_parse($conn, $sql);
        $r = oci_execute($stid);
        while ($row_out = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $subj_id = $row_out['SUBJ_ID'];
            $sql_s = "select * from contingent.moodle_study_work_view WHERE subj_id = '" . $subj_id . "' ORDER BY SEMESTER,HOURS_COUNT ";
            $stid_s = oci_parse($conn, $sql_s);
            $r_s = oci_execute($stid_s);
            while($row_study = oci_fetch_array($stid_s, OCI_ASSOC+OCI_RETURN_NULLS)){
                $result->{$subj_id} = $row;
                $year = (int)$row_study['SEMESTER'];
                $year = $year / 2;
                $year = ceil($year);
                $year = date('Y') - $year;
                $result->{$subj_id}->year = $year;
            }
        }
    }
    return $result;
}
